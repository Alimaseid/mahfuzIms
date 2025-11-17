<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Customer;
use App\Models\ItemOwner;
use App\Models\ItemReturn;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\PaymentLedger;
use App\Models\BusinessLocation;
use App\Models\ItemReturnDetail;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreItemReturnRequest;
use App\Http\Requests\UpdateItemReturnRequest;
use App\Models\Inventory;

class ItemReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customer = Customer::where('id', $id)->first();
        $location = BusinessLocation::all();
        $orders = SalesOrder::where('customer_id', $id)->where('SM_status', 'Accepted')->orderBy('created_at', 'desc')->get();
        $returns = ItemReturn::orderBy('created_at', 'desc')->where('customer_id', $id)->get();
        $returnsDetail = ItemReturnDetail::orderBy('created_at', 'desc')->get();
        $items = [];
        $items = [];
        foreach ($orders as $order) {
            $details = SalesOrderDetail::where('sales_order_id', $order->id)->get();
            foreach ($details as $detail) {
                $items[] = [
                    'order_id' => $detail->sales_order_id,
                    'item_id' => $detail->item_id,
                    'item_code' => $detail->item_name,
                    'quantity' => $detail->quantity,
                    'remaining' => $detail->remaining,
                    'tax' => $detail->tax,
                    //without tax
                    'price' => $detail->total,
                ];
            }
        }
        $data =  ['orders' => $orders, 'items' => $items];

        return view('pages.sales.salesReturn')
            ->with('data', $data)
            ->with('location', $location)
            ->with('returns', $returns)
            ->with('returnsDetail', $returnsDetail)
            ->with('customer', $customer);
    }

    public function customReturn(Request $request, $id)
    {
        $order = SalesOrder::find($id);

        // ✅ Create Item Return
        $return = ItemReturn::create([
            'return_date' => $request->return_date,
            'sales_order_id' => $id,
            'customer_id' => $order->customer_id,
            'return_by' => Auth::user()->id,
            'return_to' => $request->return_location,
            'refunded_type' => $request->refunded_type,
            'refunded_amount' => 0,
        ]);

        $return->reason = $request->reason;
        $return->save();

        $total_return = 0;

        foreach ($request->addmore as $item) {
            $sale = SalesOrderDetail::where('sales_order_id', $id)
                ->where('item_id', $item["item_id"])
                ->first();

            if (!$sale) continue;

            $batchId = $sale->batch_id;
            $unitPrice = $sale->total / $sale->quantity;
            $returnQty = (float) $item["quantity"];
            $remainingQty = max(0, $item["remaining"] - $returnQty);
            $returnCash = $returnQty * $unitPrice;

            // ✅ Prevent over-returning
            if ($returnQty > $sale->quantity) {
                continue;
            }

            $total_return += $returnCash;

            // ✅ Create ItemReturnDetail
            ItemReturnDetail::create([
                'return_id' => $return->id,
                'item_id' => $item["item_id"],
                'quantity' => $returnQty,
                'price' => $returnCash,
                'return_to' => $request->return_location,
            ]);

            // ✅ Update SalesOrderDetail (remaining quantity)
            $sale->update([
                'remaining' => $remainingQty,
            ]);

            // ✅ Update Item stock
            $originalItem = Item::find($item["item_id"]);
            $originalItem->increment('quantity', $returnQty);

            // ✅ Update Inventory stock
            $inventory = Inventory::where('item_id', $item["item_id"])
                ->where('location_id', $request->return_location)
                ->where('batch_id', $batchId)
                ->first();

            if ($inventory) {
                $inventory->increment('quantity', $returnQty);
            }

            // ✅ Ledger update if Debit
            if ($request->refunded_type == 'Debit') {
                $customer = Customer::find($order->customer_id);
                PaymentLedger::create([
                    'date' => Carbon::now(),
                    'customer_id' => $order->customer_id,
                    'voucher_type' => 'Sales Return (' . $request->refunded_type . ')',
                    'refrence_no' => 'Order No: ' . $order->reference_number,
                    'debit' => 0,
                    'credit' => $returnCash,
                    'running_balance' => $customer->total_balance - $returnCash,
                ]);

                $customer->decrement('total_balance', $returnCash);
            }
        }

        // ✅ Update refunded total
        $return->update(['refunded_amount' => $total_return]);

        // ✅ Check all SalesOrderDetail remaining values
        $remaining = SalesOrderDetail::where('sales_order_id', $id)
            ->sum('remaining');

        // If no remaining quantities, mark order as Done
        if ($remaining <= 0) {
            $order->update(['r_status' => 'Done']);
        } else {
            $order->update(['r_status' => 'Partial']);
        }

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($return)
            ->withProperties(['data' => $return])
            ->log('Item return processed');

        return back()->with('success', 'Return processed successfully.');
    }
}
