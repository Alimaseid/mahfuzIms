<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Owner;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use App\Models\SalesOrderDetail;

class StoreController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::where('SM_status', 'Pending')->orderBy('id', 'desc')->get();
        $salesOrder = SalesOrder::all();
        $businessLocations = BusinessLocation::where('type', 'Shop')->get();
        $items = Item::all();
        $salesOrderDetails = SalesOrderDetail::all();
        $customers = Customer::all();
        return view('pages.store.orderlist')
            ->with('customers', $customers)
            ->with('businessLocations', $businessLocations)
            ->with('items', $items)
            ->with('salesOrder', $salesOrder)
            ->with('salesOrderDetails', $salesOrderDetails)
            ->with('salesOrders', $salesOrders);
    }

    public function acceptOrder($id)
    {
        SalesOrder::where('id', $id)->update(['SM_status' => 'Accepted']);
        return back()->with('success', 'Order Accepted.');
    }

    public function regectOrder(Request $request, $id)
    {
        $order = SalesOrder::where('id', $id)->first();
        $orderDetail = SalesOrderDetail::where('sales_order_id', $order->id)->get();
        foreach ($orderDetail as $od) {
            $item = Item::where('id', $od->item_id)->first();
            Item::where('id', $item->id)->update([
                'quantity' => $item->quantity + $od->quantity,
            ]);
        }

        SalesOrder::where('id', $id)->update([
            'SM_status' => 'Rejected',
            'rejectReasone' => $request->rejectReasone,
        ]);
        return back()->with('success', 'Order Rejected.');
    }

    public function telegramAcceptOrder($id, $chat_id, $token, $rfn)
    {
        SalesOrder::where('id', $id)->update(['SM_status' => 'Accepted']);
        $data = [
            'text' => 'Oreder on Order Number ' . $rfn . ' Accepted',
            'chat_id' => $chat_id
        ];
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
        return redirect("https://t.me/+qCFrzpi-QTpiNWJk");
    }

    public function telegramRejectOrder($id, $chat_id, $token, $rfn)
    {
        SalesOrder::where('id', $id)->update([
            'SM_status' => 'Rejected',
            'rejectReasone' => 'Reject From Telegram',
        ]);
        $data = [
            'text' => 'Oreder on Order Number ' . $rfn . ' Rejected',
            'chat_id' => $chat_id
        ];
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
        return redirect("https://t.me/+qCFrzpi-QTpiNWJk");
    }

    public function itemTransfer()
    {
        $locations = BusinessLocation::all();
        $items = Item::where('quantity', '>', 0)->get();
        return view('pages.store.iterm_transfer')
            ->with('items', $items)
            ->with('locations', $locations);
    }

    public function storeItemTransfer(Request $request)
    {

        return back()->with('success', 'Item Transfer Successfully');
    }
}
