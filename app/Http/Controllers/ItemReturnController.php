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
        $location = BusinessLocation::where('type', 'warehouse')->get();
        $orders = SalesOrder::where('customer_id', $id)->where('SM_status', 'Done')->orderBy('created_at', 'desc')->get();
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
        //get order detail

        $order = SalesOrder::find($id);
        $data = ItemReturn::create([
            'return_date' => $request->return_date,
            'sales_order_id' => $id,
            'customer_id' => $order->customer_id,
            'return_by' => Auth::user()->id,
            'return_to' => $request->return_location,
            'refunded_type' => $request->refunded_type,
            'refunded_amount' => 0,
        ]);
        $data->reason = $request->reason;
        $data->save();


        $return = ItemReturn::latest()->first();
        $total_return = 0;
        foreach ($request->addmore as $item) {
            $sale = SalesOrderDetail::where('sales_order_id', $id)->where('item_id', $item["item_id"])->first();
            // return $sale;

            $unitPrice =  $sale->total / $sale->quantity;
            $returnCash = $item["quantity"] * $unitPrice;
            if ($sale->quantity >= $item["quantity"]) {
                $total_return = $total_return + $returnCash;

                ItemReturnDetail::create([
                    'return_id' => $return->id,
                    'item_id' => $item["item_id"],
                    'quantity' => $item["quantity"],
                    'price' => $returnCash,
                    'return_to' => $request->return_location,
                ]);

                // SalesOrderDetail::where('sales_order_id',$id)->where('item_id',$item["item_id"])
                // ->update([
                //     'quantity' => $sale->quantity - $item["quantity"],
                //     'total' => $sale->total - $returnCash
                //     ]);

                $originalItem =  Item::find($item["item_id"]);
                Item::where('id', $item["item_id"])->update([
                    'quantity' => $originalItem->quantity + $item["quantity"]
                ]);

                $owner_item =  ItemOwner::where('item_id', $sale->item_id)
                    ->where('owner_id', $sale->owner_id)
                    // ->where('location_id',$sale->location_id)
                    ->first();
                ItemOwner::where('item_id', $item["item_id"])
                    ->where('owner_id', $sale->owner_id)
                    ->where('location_id', $request->return_location)
                    ->update(['quantity' => $owner_item->quantity + $item["quantity"]]);

                if ($request->refunded_type == 'Debit') {
                    // $latest_ladger = PaymentLedger::where('customer_id', $order->customer_id)->latest()->first();
                    $customer = Customer::find($order->customer_id);
                    PaymentLedger::create([
                        'date' => Carbon::now(),
                        'customer_id' => $order->customer_id,
                        'voucher_no' => null,
                        'voucher_type' => 'Sales Return, Type: ' . $request->refunded_type,
                        'refrence_no' => 'On Order No: ' . $order->reference_number,
                        'debit' => 0,
                        'credit' => $returnCash,
                        'running_balance' => $customer->total_balance - $returnCash,
                    ]);


                    $customer->total_balance = $customer->total_balance - $returnCash;
                    $customer->save();
                }
            }
        }
        ItemReturn::where('id', $return->id)->update(['refunded_amount' => $total_return]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($data)
            ->withProperties(['data' => $data])
            ->log('Create new item return');
        return back()->with('success', 'Saved.');
    }
}
