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
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Role;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $salesOrders = SalesOrder::orderBy('id', 'desc')->take(100)->get();
        $salesOrders = SalesOrder::with(['details.item'])->orderBy('id', 'desc')->take(100)->get();
        $businessLocations = BusinessLocation::all();
        $salesOrderDetails = SalesOrderDetail::orderBy('id', 'desc')->take(2000)->get();
        $customers = Customer::all();
        $categories = Category::select('id', 'name')->get();
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.sales.sales')
            ->with('customers', $customers)
            ->with('businessLocations', $businessLocations)
            ->with('salesOrderDetails', $salesOrderDetails)
            ->with('categories', $categories)
            ->with('permission', $permission)
            ->with('salesOrders', $salesOrders);
    }

    public function create()
    {
        $businessLocations = BusinessLocation::all();
        $customers = Customer::all();
        $categories = Category::select('id', 'name')->get();

        return view('pages.sales.addsales')
            ->with('customers', $customers)
            ->with('businessLocations', $businessLocations)
            ->with('categories', $categories);
    }

    public function edit($id)
    {
        $salesOrder = SalesOrder::find($id);
        $salesOrders = SalesOrder::with(['details.item'])->orderBy('id', 'desc')->take(100)->get();
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $salesOrder->id)->get();
        $businessLocations = BusinessLocation::all();
        $customers = Customer::all();
        $categories = Category::select('id', 'name')->get();

        return view('pages.sales.editsales')
            ->with('customers', $customers)
            ->with('businessLocations', $businessLocations)
            ->with('categories', $categories)
            ->with('salesOrder', $salesOrder)
            ->with('salesOrders', $salesOrders)
            ->with('salesOrderDetails', $salesOrderDetails);
    }
    public function addSalesOrder(Request $request)
    {
        // 1️⃣ Reject reused tokens
        $exists = DB::table('request_tokens')
            ->where('token', $request->request_token)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Duplicate submission blocked.');
        }

        // 2️⃣ Store token immediately so duplicates are blocked
        DB::table('request_tokens')->insert([
            'token' => $request->request_token,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // basic validation
        $request->validate([
            'customer' => 'required|exists:customers,id',
            'business_location' => 'required|exists:business_locations,id',
            'refrence_no' => 'required|string',
            'sales_type' => 'required|string',
            'addmore' => 'required|array|min:1',
            'addmore.*.item_id' => 'required|integer|exists:items,id',
            'addmore.*.quantity' => 'required|numeric|min:1',
            'addmore.*.u_price' => 'required|numeric|min:0',
        ]);

        // Convert discount percent to fraction
        $discountPercent = floatval($request->discount ?? 0); // e.g., 10 -> 10%
        $discountRate = ($discountPercent) / 100.0;

        // VAT and withholding rates: checkboxes carry fractional values (e.g. 0.15 or 0.03) when checked.
        $vatRate = floatval($request->vat_include ?? 0); // already fractional if checkbox used (0.15)
        $withHoldingRate = floatval($request->with_holding ?? 0);

        // Create the sales order first (basic fields)
        $salesOrder = SalesOrder::create([
            'customer_id'      => $request->customer,
            'reference_number' => $request->refrence_no,
            'sales_person'     => Auth::user()->name ?? null,
            'sales_type'       => $request->sales_type,
            'payment_type'     => $request->payment_type ?? 'Cash',
            'location_id'      => $request->business_location,
            'payment_status'   => 'Unpaid',
        ]);

        // Accumulators for totals
        $grandTotal = 0.0;
        $totalVat = 0.0;
        $totalDiscount = 0.0;
        $totalWithHolding = 0.0;

        foreach ($request->addmore as $line) {
            $item = Item::find($line['item_id']);
            if (!$item) {
                // skip missing item
                continue;
            }

            $qty = floatval($line['quantity']);
            $unitPrice = floatval($line['u_price']);
            $lineAmount = $unitPrice * $qty; // raw line amount before discount/tax

            // Per-line discount/vat/withholding
            $lineDiscount = $lineAmount * $discountRate;
            $afterDiscount = $lineAmount - $lineDiscount;
            $lineVat = $afterDiscount * $vatRate;
            $lineWithHolding = $afterDiscount * $withHoldingRate;
            $lineNet = $afterDiscount + $lineVat - $lineWithHolding; // what the customer pays for this line

            // Persist detail
            SalesOrderDetail::create([
                'item_id'        => $item->id,
                'batch_id'       => $line['batch_id'] ?? null,
                'location_id'    => $request->business_location,
                'item_name'      => $item->item_name ?? $item->name ?? 'Item',
                'quantity'       => $qty,
                'remaining'       => $qty,
                'amount'         => $line['u_price'],           // raw line amount (before discount/tax)
                'tax'            => $lineVat,
                'with_holding'   => $lineWithHolding,
                'discount'       => $lineDiscount,
                'total'          => $lineNet,              // net amount for the line
                'sales_order_id' => $salesOrder->id,
            ]);

            // Update inventory (if you track inventory as per inventory table)
            $inventory = Inventory::where('item_id', $item->id)
                ->where('location_id', $request->business_location)
                ->where('batch_id', $line['batch_id'])
                ->first();

            if ($inventory) {
                $inventory->quantity = max(0, $inventory->quantity - $qty);
                $inventory->save();
            } else {
                // Optionally log missing inventory record
                return with("Inventory record missing for item {$item->id} at location {$request->business_location}");
            }

            // accumulate totals
            $grandTotal += $lineNet;
            $totalVat += $lineVat;
            $totalDiscount += $lineDiscount;
            $totalWithHolding += $lineWithHolding;
        }

        // Update sales order totals
        $salesOrder->update([
            'grand_total'   => $grandTotal,
            'vat'           => $totalVat,
            'discount'      => $totalDiscount,
            'with_holding'  => $totalWithHolding,
        ]);

        // Set SM_status if location type is 'Shop'
        if ($salesOrder->location && (isset($salesOrder->location->type) && $salesOrder->location->type === 'Shop')) {
            $salesOrder->SM_status = 'Accepted';
            $salesOrder->save();
        }

        // Ledger entry
        $latest_ledger = PaymentLedger::where('customer_id', $request->customer)->latest()->first();
        PaymentLedger::create([
            'date'            => \Carbon\Carbon::now(),
            'customer_id'     => $request->customer,
            'narration'       => $salesOrder->id,
            'voucher_no'      => $request->refrence_no,
            'voucher_type'    => 'sales',
            'refrence_no'     => $request->refrence_no,
            'debit'           => $grandTotal,
            'credit'          => 0,
            'running_balance' => ($latest_ledger->running_balance ?? 0) + $grandTotal,
        ]);

        // Update customer balance
        $customer = Customer::find($request->customer);
        if ($customer) {
            $customer->total_balance = ($customer->total_balance ?? 0) + $grandTotal;
            $customer->save();
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['grand_total' => $grandTotal])
            ->log('Created Sales Order');

        return redirect('/sales-order')->with('success', 'Registered Order Successfully.');
    }


    // ✅ Edit Sales Order


    public function editSalesOrder(Request $request, $id)
    {


        // ✅ Validation (same as addSalesOrder, just reference_no fixed)
        // $request->validate([
        //     'customer' => 'required|exists:customers,id',
        //     'business_location' => 'required|exists:business_locations,id',
        //     'reference_no' => 'required|string',
        //     'sales_type' => 'required|string',
        //     'addmore' => 'required|array|min:1',
        //     'addmore.*.item_id' => 'required|integer|exists:items,id',
        //     'addmore.*.quantity' => 'required|numeric|min:1',
        //     'addmore.*.u_price' => 'required|numeric|min:0',
        // ]);

        $salesOrder = SalesOrder::findOrFail($id);

        // ✅ Convert discount % to fraction
        $discountPercent = floatval($request->discount ?? 0);
        $discountRate = $discountPercent / 100.0;

        // ✅ VAT & withholding (checkboxes → fraction)
        $vatRate = floatval($request->vat_include ?? 0);      // e.g., 0.15
        $withHoldingRate = floatval($request->with_holding ?? 0); // e.g., 0.03

        // ✅ Update sales order basic info
        $salesOrder->update([
            'customer_id'      => $request->customer,
            'reference_number' => $request->reference_no,
            'sales_person'     => Auth::user()->name ?? null,
            'sales_type'       => $request->sales_type,
            'location_id'      => $request->business_location,
            'SM_status'        => 'Pending',
        ]);

        // ✅ Reset totals (we will recalc)
        $grandTotal = 0.0;
        $totalVat = 0.0;
        $totalDiscount = 0.0;
        $totalWithHolding = 0.0;

        // ✅ Loop items
        foreach ($request->addmore as $line) {
            $item = Item::find($line['item_id']);
            if (!$item) continue;

            $qty = floatval($line['quantity']);
            $unitPrice = floatval($line['u_price']);
            $lineAmount = $unitPrice * $qty;

            // line calculations
            $lineDiscount = $lineAmount * $discountRate;
            $afterDiscount = $lineAmount - $lineDiscount;
            $lineVat = $afterDiscount * $vatRate;
            $lineWithHolding = $afterDiscount * $withHoldingRate;
            $lineNet = $afterDiscount + $lineVat - $lineWithHolding;

            // check if detail already exists
            $detail = SalesOrderDetail::where('sales_order_id', $salesOrder->id)
                ->where('item_id', $item->id)
                ->first();

            if ($detail) {
                // adjust inventory based on difference
                $oldQty = $detail->quantity;
                $diff = $qty - $oldQty;

                $inventory = Inventory::where('item_id', $item->id)
                    ->where('location_id', $request->business_location)
                    ->where('batch_id', $line['batch_id'])
                    ->first();

                if ($inventory) {
                    $inventory->quantity = max(0, $inventory->quantity - $diff);
                    $inventory->save();
                }

                $detail->update([
                    'batch_id'       => $line['batch_id'] ?? null,
                    'location_id'    => $request->business_location,
                    'item_name'      => $item->item_name ?? $item->name ?? 'Item',
                    'quantity'       => $qty,
                    'amount'         => $unitPrice,
                    'tax'            => $lineVat,
                    'with_holding'   => $lineWithHolding,
                    'discount'       => $lineDiscount,
                    'total'          => $lineNet,
                ]);
            } else {
                // create new detail
                SalesOrderDetail::create([
                    'item_id'        => $item->id,
                    'batch_id'       => $line['batch_id'] ?? null,
                    'location_id'    => $request->business_location,
                    'item_name'      => $item->item_name ?? $item->name ?? 'Item',
                    'quantity'       => $qty,
                    'amount'         => $unitPrice,
                    'tax'            => $lineVat,
                    'with_holding'   => $lineWithHolding,
                    'discount'       => $lineDiscount,
                    'total'          => $lineNet,
                    'sales_order_id' => $salesOrder->id,
                ]);

                // reduce inventory
                $inventory = Inventory::where('item_id', $item->id)
                    ->where('location_id', $request->business_location)
                    ->first();

                if ($inventory) {
                    $inventory->quantity = max(0, $inventory->quantity - $qty);
                    $inventory->save();
                }
            }

            // accumulate totals
            $grandTotal += $lineNet;
            $totalVat += $lineVat;
            $totalDiscount += $lineDiscount;
            $totalWithHolding += $lineWithHolding;
        }

        // ✅ Update order totals
        $salesOrder->update([
            'grand_total'   => $grandTotal,
            'vat'           => $totalVat,
            'discount'      => $totalDiscount,
            'with_holding'  => $totalWithHolding,
        ]);

        // ✅ Auto-accept if shop
        if ($salesOrder->location && ($salesOrder->location->type === 'Shop')) {
            $salesOrder->update(['SM_status' => 'Accepted']);
        }

        // ✅ Update ledger
        $ledger = PaymentLedger::where('customer_id', $salesOrder->customer_id)
            ->where('narration', $salesOrder->id)
            ->first();

        if ($ledger) {
            $change = $grandTotal - $ledger->debit;
            $ledger->update([
                'debit'           => $grandTotal,
                'running_balance' => $ledger->running_balance + $change,
            ]);

            // update subsequent ledgers
            $affectedLedgers = PaymentLedger::where('id', '>', $ledger->id)->get();
            foreach ($affectedLedgers as $lg) {
                $lg->update(['running_balance' => $lg->running_balance + $change]);
            }

            // update customer balance
            $customer = Customer::find($salesOrder->customer_id);
            if ($customer) {
                $customer->update(['total_balance' => $customer->total_balance + $change]);
            }
        }

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['grand_total' => $grandTotal])
            ->log('Edited Sales Order');

        return redirect('/sales-order')->with('success', 'Edit Order Successfully.');
    }



    // ✅ Delete Sales Order
    public function deleteSalesOrders($id)
    {
        $salesOrder = SalesOrder::findOrFail($id);
        $orderDetails = SalesOrderDetail::where('sales_order_id', $id)->get();
        PaymentLedger::where('customer_id', $salesOrder->customer_id)
            ->where('narration', $salesOrder->id)
            ->delete();

        // ✅ Log activity before deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($salesOrder)
            ->withProperties(['order_id' => $salesOrder->id])
            ->log('Deleted Sales Order');
        $location = $salesOrder->location_id;
        foreach ($orderDetails as $order) {
            $inventory = Inventory::where('item_id', $order->item_id)
                ->where('location_id', $location)
                ->where('batch_id', $order->batch_id)
                ->first();

            if ($inventory) {
                $inventory->quantity = max(0, $inventory->quantity + $order->quantity);
                $inventory->save();
            }
        }
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
        $salesorderDetails = SalesOrderDetail::all();
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
                        'item_name' => $item->item_name,
                        'item_code' => $item->product_code,
                        'part_number' => $item->part_number,
                        'unit' => $item->unit,
                        'category' => $item->category,
                        'shelf' => $item->shelf,
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
                        'location' => $location->name ?? '',
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
            ->with('salesorderDetails', $salesorderDetails)
            ->with('salesOrder', $salesOrder)
            ->with('data', $data);
    }

    public function getItemForSale(Request $request)
    {
        $locationId = $request->input('location_id');
        $category   = $request->input('category');

        $query = Inventory::with('item')->where('quantity', '>', 0);

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $inventories = $query->get();

        $items = $inventories->map(function ($inventory) use ($category) {
            $item = $inventory->item;


            if (!$item) return null;

            // ✅ filter by category
            if ($category && $item->category !== $category) {
                return null;
            }

            return [
                'id'             => $item->id,
                'batch_id'       => $inventory->batch_id,
                'batch_number'   => $inventory->batch->batch_number, // ✅ expose batch id
                'item_name'      => $item->item_name,
                'product_code'   => $item->product_code,
                'selling_price1' => $item->selling_price1 ?? 0,
                'selling_price2' => $item->selling_price2 ?? 0,
                'selling_price3' => $item->selling_price3 ?? 0,
                'image'          => $item->image ? asset(str_replace('\\', '/', $item->image)) : null,
                'image2'         => $item->image2 ? asset(str_replace('\\', '/', $item->image2)) : null,
                'quantity'       => $inventory->quantity,
                'category'       => $item->category,
            ];
        })->filter();

        return response()->json($items->values());
    }
    public function e_getItemForSale(Request $request)
    {
        $locationId = $request->input('location_id');
        $category   = $request->input('category');   // category NAME from edit-sales

        $query = Inventory::with(['item', 'batch'])
            ->where('quantity', '>', 0);

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $inventories = $query->get();

        $items = $inventories->map(function ($inventory) use ($category) {

            $item = $inventory->item;
            if (!$item) return null;

            // ✔ FIX: Category filtering using STRING (name)
            if ($category && $item->category !== $category) {
                return null;
            }

            return [
                'id'           => $item->id,
                'item_name'    => $item->item_name,
                'product_code' => $item->product_code,
                'quantity'     => $inventory->quantity,
                'batch_id'     => $inventory->batch_id,
                'batch_number' => $inventory->batch?->batch_number,
                'selling_price1' => $item->selling_price1,
                'selling_price2' => $item->selling_price2,
                'selling_price3' => $item->selling_price3,
                'image'        => $item->image ? asset($item->image) : null,
            ];
        })->filter();

        return response()->json($items->values());
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
            ->with('salesOrder', $salesOrder)
            ->with('salesOrderDetails', $salesOrderDetails);
    }
}
