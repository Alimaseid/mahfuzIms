<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Owner;
use App\Models\Vendor;
use App\Models\Issuing;
use App\Models\Customer;
use App\Models\ItemOwner;
use App\Models\ShopSales;
use App\Models\ItemOnShop;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentLedger;
use App\Models\BusinessLocation;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;
use Psy\CodeCleaner\ReturnTypePass;

// use App\Http\Controllers\TelegramController;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = Carbon::now()->startOfWeek();
        // $salesOrders = SalesOrder::orderBy('id', 'desc')->latest()->take(12)->get();
        $salesOrders = SalesOrder::orderBy('id', 'desc')->latest()->take(100)->get();
        $vendors = Vendor::all();
        $businessLocations = BusinessLocation::all();
        $owners = Owner::all();

        $items = Item::where('quantity', '>', 0)->get();
        $salesOrderDetails = SalesOrderDetail::all();
        $customers = Customer::all();

        return view('pages.sales.sales')
            ->with('owners', $owners)
            ->with('customers', $customers)
            ->with('businessLocations', $businessLocations)
            ->with('items', $items)
            ->with('vendors', $vendors)
            ->with('salesOrderDetails', $salesOrderDetails)
            ->with('salesOrders', $salesOrders);
    }



    public function addSalesOrder(Request $request)
    {
        $salesOrder = SalesOrder::create([
            'customer_id'       => $request->customer,
            'reference_number'  => $request->refrence_no,
            'sales_person'      => Auth::user()->name,
            'sales_type'        => $request->sales_type,
            'location_id'       => $request->business_location,
            'payment_status'    => Carbon::now('+3')->toDateTimeString(),
        ]);

        $grand_total = 0;

        foreach ($request->addmore as $line) {
            $item = Item::find($line['item_id']);
            $total = $line['u_price'] * $line['quantity'];
            $subtotal = ($total * $request->vat_include / 100) + $total;
            $grand_total += $subtotal;

            SalesOrderDetail::create([
                'item_id'        => $item->id,
                'location_id'    => $request->business_location,
                'item_name'      => $item->product_code,
                'quantity'       => $line['quantity'],
                'amount'         => $total,
                'tax'            => $request->vat_include,
                'total'          => $subtotal,
                'sales_order_id' => $salesOrder->id,
            ]);

            $item->update(['quantity' => $item->quantity - $line['quantity']]);
        }

        $salesOrder->update(['grand_total' => $grand_total]);

        $latest_ladger = PaymentLedger::where('customer_id', $request->customer)->latest()->first();
        PaymentLedger::create([
            'date'            => Carbon::now(),
            'customer_id'     => $request->customer,
            'narration'       => $salesOrder->id,
            'voucher_no'      => $request->refrence_no,
            'voucher_type'    => 'sales',
            'refrence_no'     => $request->refrence_no,
            'debit'           => $grand_total,
            'credit'          => 0,
            'running_balance' => $latest_ladger->running_balance + $grand_total,
        ]);

        $customer = Customer::find($request->customer);
        $customer->update(['total_balance' => $customer->total_balance + $grand_total]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['grand_total' => $grand_total])
            ->log('Created Sales Order');

        return back()->with('success', 'Register Order Successfully.');
    }

    // ✅ Edit Sales Order
    public function editSalesOrder(Request $request, $id)
    {
        $salesOrder = SalesOrder::findOrFail($id);

        $salesOrder->update([
            'customer_id'      => $request->customer,
            'reference_number' => $request->refrence_no,
            'sales_person'     => Auth::user()->name,
            'sales_type'       => $request->sales_type,
            'location_id'      => $request->business_location,
            'SM_status'        => 'Pending',
        ]);

        $grand_total = 0;

        foreach ($request->addmore as $line) {
            $item = Item::find($line['item_id']);
            $total = $line['u_price'] * $line['quantity'];
            $subtotal = ($total * $request->vat_include / 100) + $total;
            $grand_total += $subtotal;

            $oldDetail = SalesOrderDetail::where('sales_order_id', $id)
                ->where('item_id', $item->id)
                ->first();

            $diff = $oldDetail->quantity - $line['quantity'];

            $oldDetail->update([
                'item_id'        => $item->id,
                'location_id'    => $request->business_location,
                'item_name'      => $item->product_code,
                'quantity'       => $line['quantity'],
                'amount'         => $total,
                'tax'            => $request->vat_include,
                'total'          => $subtotal,
            ]);

            if ($diff != 0 && $oldDetail->owner_id != 666) {
                $item->update(['quantity' => $item->quantity - (-$diff)]);
            }

            if ($oldDetail->owner_id == 666 && $diff != 0) {
                $itemOnShop = ItemOnShop::where('item_id', $item->id)->first();
                $itemOnShop->update(['qauntity' => $itemOnShop->qauntity - (-$diff)]);
            }
        }

        $salesOrder->update(['grand_total' => $grand_total]);

        $ledger = PaymentLedger::where('customer_id', $salesOrder->customer_id)
            ->where('narration', $salesOrder->id)
            ->first();

        $change = $grand_total - $ledger->debit;

        $ledger->update([
            'debit'           => $grand_total,
            'running_balance' => $ledger->running_balance - (-$change),
        ]);

        $affected_ledgers = PaymentLedger::where('id', '>', $ledger->id)->get();
        foreach ($affected_ledgers as $lg) {
            $lg->update(['running_balance' => $lg->running_balance - (-$change)]);
        }

        $customer = Customer::find($salesOrder->customer_id);
        $customer->update(['total_balance' => $customer->total_balance - (-$change)]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['grand_total' => $grand_total, 'change' => $change])
            ->log('Edited Sales Order');

        return back()->with('success', 'Edit Order Successfully.');
    }

    // ✅ Delete Sales Order
    public function deleteSalesOrders($id)
    {
        $salesOrder = SalesOrder::findOrFail($id);
        $orderDetails = SalesOrderDetail::where('sales_order_id', $id)->get();

        foreach ($orderDetails as $detail) {
            $itemOwner = ItemOwner::where('owner_id', $salesOrder->owner_id)
                ->where('item_id', $detail->item_id)
                ->first();

            if ($itemOwner) {
                $itemOwner->update(['quantity' => $itemOwner->quantity + $detail->quantity]);
            }
        }

        PaymentLedger::where('customer_id', $salesOrder->customer_id)
            ->where('narration', $salesOrder->id)
            ->delete();

        // ✅ Log activity before deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['order_id' => $salesOrder->id])
            ->log('Deleted Sales Order');

        $salesOrder->delete();
        SalesOrderDetail::where('sales_order_id', $id)->delete();

        return back()->with('success', 'Delete Order Successfully.');
    }

    public function unpaidSales()
    {
        $sales = SalesOrder::orderBy('created_at', 'desc')->where('sales_type', 'Credit Sales')->get();
        $sale = SalesOrder::where('sales_type', 'Credit Sales')->get();
        $owners = Owner::all();
        $locations = BusinessLocation::all();
        $customers = Customer::all();
        $salesOrderDetails = SalesOrderDetail::all();
        $owners = Owner::all();
        return view('pages.sales.salesPayment')
            ->with('sale', $sale)
            ->with('sales', $sales)
            ->with('owners', $owners)
            ->with('locations', $locations)
            ->with('customers', $customers)
            ->with('salesOrderDetails', $salesOrderDetails);
    }



    public function acceptIssue($id)
    {
        $order = SalesOrder::where('id', $id)->first();
        PaymentLedger::where('narration', $id)->update(['status' => 'Approved']);
        SalesOrder::where('id', $id)->update(['SM_status' => 'Done']);
        Issuing::where('issued_to', $order->location_id)->where('voucher_number', $order->reference_number)->update(['status' => 'Accepted']);
        return back()->with('success', 'Done.');
    }



    public function addSalesOrderFromShop(Request $request)
    {
        // return $request->x_addmore;
        $shop_item_quantity = 0;
        $g_total = 0;
        foreach ($request->x_addmore as $item_list) {
            $order = SalesOrder::where('reference_number', $request->refrence_no)->first();
            $qyt = ItemOnShop::where('item_id', $item_list['item_id'])->where('location_id', $request->business_location)->first();

            $amount = $item_list['quantity'] * $item_list['u_price'];
            $total = $amount + ($amount * $request->x_vat_include / 100);
            $g_total = $g_total + $total;
            $shop_item_quantity = $shop_item_quantity + $item_list['quantity'];
            SalesOrderDetail::create([
                'item_id' => $item_list['item_id'],
                'location_id' => $request->business_location,
                'item_name' => Str::before($item_list['search_item'], "|"),
                'quantity' => $item_list['quantity'],
                'tax' => $request->x_vat_include,
                'owner_id' => 666,
                'amount' => $amount,
                'total' => $total,
                'sales_order_id' => $order->id,

            ]);

            ShopSales::create([
                'sales_id' => $order->id,
                'location_id' => $request->business_location,
                'item_name' => Str::before($item_list['search_item'], "|"),
                'quantity' => $item_list['quantity'],

            ]);

            ItemOnShop::where('item_id', $item_list['item_id'])->where('location_id', $request->business_location)
                ->update(
                    [
                        'qauntity' => $qyt->qauntity - $item_list['quantity'],
                    ]
                );

            $item =  Item::where('id', $item_list['item_id'])->first();
            $item->quantity = $item->quantity - $item_list['quantity'];
            $item->save();

            $item_owner_qyt = ItemOwner::where('item_id', $item_list['item_id'])
                ->where('location_id', $request->business_location)->first();
            $item_owner_qyt->quantity = $item_owner_qyt->quantity - $item_list['quantity'];
            $item_owner_qyt->save();
        }

        $customer = Customer::find($order->customer_id);

        $ladger = PaymentLedger::where('customer_id', $order->customer_id)->where('narration', $order->id)->first();
        PaymentLedger::where('customer_id', $order->customer_id)->where('narration', $order->id)
            ->update(['debit' => $order->grand_total + $g_total, 'running_balance' => $customer->total_balance + $g_total]);
        $lgr = PaymentLedger::where('id', '>', $ladger->id)->get();
        foreach ($lgr as $lg) {
            PaymentLedger::where('id', $lg->id)
                ->update(['running_balance' => $lg->running_balance + $g_total]);
        }

        $customer->total_balance  = $customer->total_balance + $g_total;
        $customer->save();

        SalesOrder::where('reference_number', $request->refrence_no)->update([
            'grand_total' => $order->grand_total + $g_total,
        ]);

        return back()->with('success', 'Additional items added to ' . $request->refrence_no . ' Order.');
    }


    public function customerSalesHitory($id)
    {
        $salesOrder = SalesOrder::where('customer_id', $id)->orderBy('created_at', 'desc')->get();
        $customer = Customer::find($id);
        $data = [];
        foreach ($salesOrder as $so) {
            $sods = SalesOrderDetail::where('sales_order_id', $so->id)->get();
            foreach ($sods as $sod) {
                $item = Item::find($sod->item_id);
                if (!empty($item)) {
                    // $owner = Owner::find($sod->owner_id);
                    $pod_data[] = [
                        // 'owner' => $owner->name,
                        'order_id' => $sod->sales_order_id,
                        'item_id' => $item->id,
                        'item_code' => $item->product_code,
                        'quantity' => $sod->quantity,
                        'total' => $sod->amount,
                        'tax' => $sod->tax,
                        'grand_total' => $sod->total,
                    ];
                }
            }
            $location = BusinessLocation::find($so->location_id);
            if (!empty($item)) {
                if (!empty($item)) {
                    $data[] = [
                        'id' => $so->id,
                        'date' => $so->created_at,
                        'RF' => $so->reference_number,
                        'location' => $location->name,
                        'sales_type' => $so->sales_type,
                        'sales_person' => $so->sales_person,
                        'total_payment' => $so->grand_total,
                        'status' => $so->SM_status,
                        'Details' => $pod_data
                    ];
                }
            }
        }
        return view('pages.customers.customerSalesHistory')

            ->with('vendor', $customer->name)
            ->with('data', $data);
    }

    public function getItemForSale(Request $request)
    {
        $items = Item::where('status', 'Active')
            ->where('quantity', '>', 0)
            ->get();

        // Keep images as relative paths, do NOT wrap with asset() here
        $items->transform(function ($item) {
            $item->image = $item->image ? str_replace('\\', '/', $item->image) : null;
            $item->image2 = $item->image2 ? str_replace('\\', '/', $item->image2) : null;
            return $item;
        });

        return response()->json($items);
    }


    public function xgetItemForSale(Request $request)
    {
        $items = ItemOnShop::where('qauntity', '>', 0)
            ->with('item')
            ->get();

        return json_encode($items);
    }


    public function printSalesInvoice($id)
    {

        $salesOrder = SalesOrder::where('id', $id)->first();
        $businessLocation = BusinessLocation::where('id', $salesOrder->location_id)->first();
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $salesOrder->id)->get();
        $customer = Customer::where('id', $salesOrder->customer_id)->first();
        $invoice_data = [
            'order' => $salesOrder,
            'location' => $businessLocation,
            'customer' => $customer,
            'salesDetail' => $salesOrderDetails
        ];
        // return $invoice_data;
        return view('pages.sales.invoice')
            ->with('invoice_data', $invoice_data);
    }
}
