<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Owner;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\BusinessLocation;
use App\Models\PurchaseOrderDetail;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\BankList;
use App\Models\Batch;
use App\Models\GoodReceiving;
use App\Models\ItemOwner;
use App\Models\ItemUnit;
use App\Models\PurchaseLedger;
use App\Models\PurchsePayment;
use App\Models\Shelf;
use Illuminate\Support\Str;


class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $good_receivings = GoodReceiving::orderBy('id', 'desc')->get();
        $categories = Category::all();
        $shelfs = Shelf::all();
        $item_units = ItemUnit::all();
        $items = Item::all();
        $batchs = Batch::all();
        $businessLocations = BusinessLocation::where('type', 'Warehouse')->get();

        return view('pages.goodreceiving.good_receiving')
            ->with('categories', $categories)
            ->with('businessLocations', $businessLocations)
            ->with('good_receivings', $good_receivings)
            ->with('shelfs', $shelfs)
            ->with('items', $items)
            ->with('batchs', $batchs)
            ->with('item_units', $item_units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPurchaseOrder(Request $request)
    {
        $photo = $request->file('image');
        $doc_path = '';
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-images', $doc_name);
        }

        $photos = $request->file('image2');
        $doc_paths = '';
        if ($photos) {
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-images', $doc_names);
        }

        $goodReceiving = GoodReceiving::create([
            'item_name' => $request->item_name,
            'shelves_id' => $request->shelves_id,
            'category' => $request->category,
            'product_code' => $request->product_code,
            'part_number' => $request->part_number,
            'unit' => $request->unit,
            'cost_price' => $request->cost_price,
            'selling_price1' => $request->selling_price1,
            'selling_price2' => $request->selling_price2,
            'item_code' => $request->item_code,
            'image' => $doc_path,
            'image2' => $doc_paths,
            'bar_code' => $request->bar_code,
            'status' => 'Active',
            'description' => $request->description,
            'reorder' => $request->reorder,
            'quantity' => $request->quantity,
            'brand' => $request->brand,
            'invoice_no' => $request->invoice_no,
            'receiving_date' => $request->receiving_date,
            'location_name' => $request->location_name,
        ]);

        $item = Item::where('item_name', $request->item_name ?? null)
            ->where('product_code', $request->product_code ?? null)
            ->where('part_number', $request->part_number ?? null)
            ->where('bar_code', $request->bar_code ?? null)
            ->first();

        if ($item) {
            // Update existing item quantity
            $item->update([
                'quantity' => (int) $item->quantity + $request->quantity,
            ]);
        } else {
            Item::create([
                'item_name' => $request->item_name,
                'shelves_id' => $request->shelves_id,
                'category' => $request->category,
                'product_code' => $request->product_code,
                'part_number' => $request->part_number,
                'unit' => $request->unit,
                'cost_price' => $request->cost_price,
                'selling_price1' => $request->selling_price1,
                'selling_price2' => $request->selling_price2,
                'item_code' => $request->item_code,
                'image' => $doc_path,
                'image2' => $doc_paths,
                'bar_code' => $request->bar_code,
                'status' => 'Active',
                'description' => $request->description,
                'reorder' => $request->reorder,
                'quantity' => $request->quantity,
                'brand' => $request->brand
            ]);
        }

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($goodReceiving)
            ->withProperties(['data' => $goodReceiving->toArray()])
            ->log('Added a new Good Receiving');

        return back()->with('success', 'Good Receiving Added Successfully.');
    }

    // ✅ Edit Purchase Order
    public function editPurchaseOrder(Request $request, $id)
    {
        $goodReceiving = GoodReceiving::findOrFail($id);

        $photo = $request->file('image');
        $doc_path = $goodReceiving->image;
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-images', $doc_name);
        }

        $photos = $request->file('image2');
        $doc_paths = $goodReceiving->image2;
        if ($photos) {
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-images', $doc_names);
        }

        $oldQuantity = $goodReceiving->quantity;

        $goodReceiving->update([
            'item_name' => $request->item_name,
            'shelves_id' => $request->shelves_id,
            'category' => $request->category,
            'product_code' => $request->product_code,
            'part_number' => $request->part_number,
            'unit' => $request->unit,
            'cost_price' => $request->cost_price,
            'selling_price1' => $request->selling_price1,
            'selling_price2' => $request->selling_price2,
            'item_code' => $request->item_code,
            'image' => $doc_path,
            'image2' => $doc_paths,
            'bar_code' => $request->bar_code,
            'quantity' => $request->quantity,
            'brand' => $request->brand,
            'reorder' => $request->reorder,
            'description' => $request->description,
            'invoice_no' => $request->invoice_no,
            'receiving_date' => $request->receiving_date,
            'location_name' => $request->location_name,
        ]);

        // Update item quantity
        $item = Item::where('item_name', $request->item_name ?? null)
            ->where('product_code', $request->product_code ?? null)
            ->where('part_number', $request->part_number ?? null)
            ->where('bar_code', $request->bar_code ?? null)
            ->first();

        if ($item) {
            $item->update([
                'quantity' => (int) $item->quantity - $oldQuantity + $request->quantity,
            ]);
        }

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($goodReceiving)
            ->withProperties(['old_quantity' => $oldQuantity, 'new_quantity' => $request->quantity])
            ->log('Edited Good Receiving');

        return back()->with('success', 'Good Receiving Updated Successfully.');
    }

    // ✅ Delete Purchase Order
    public function deletePurchaseOrders($id)
    {
        $purchase = PurchaseOrder::findOrFail($id);

        $orderDetails = PurchaseOrderDetail::where('purchase_order_id', $id)->get();
        foreach ($orderDetails as $data) {
            $item = Item::find($data->item_id);
            $itemOwner = ItemOwner::where('owner_id', $purchase->owner)
                ->where('item_id', $data->item_id)
                ->first();

            if ($itemOwner) {
                $itemOwner->update(['quantity' => $itemOwner->quantity - $data->qunatity]);
                $item->update(['quantity' => $item->quantity - $data->qunatity]);
            }
        }

        // ✅ Log activity before deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($purchase)
            ->withProperties(['order_id' => $purchase->id])
            ->log('Deleted Purchase Order');

        PurchaseOrder::where('id', $id)->delete();
        PurchaseOrderDetail::where('purchase_order_id', $id)->delete();

        return back()->with('success', 'Delete Order Successfully.');
    }

    public function purchsePayments($id)
    {
        $vender = Vendor::where('id', $id)->first();
        $owners = Owner::all();
        $purchasPayments = PurchsePayment::where('vendor_id', $id)->get();
        $banks = BankList::all();
        $ledger = PurchaseLedger::orderBy('created_at', 'desc')->where('to', $id)->get();
        $latestBalance = PurchaseLedger::where('to', $id)->latest()->first();

        $data = [];
        $own = [];
        $owner_balance = [];
        foreach ($ledger as $lg) {
            foreach ($owners as $owner) {
                if ($owner->id == $lg->by) {
                    $data[] = [
                        'id' => $lg->id,
                        'date' => $lg->created_at->toDateString(),
                        'credit' => $lg->credit,
                        'owner' => $owner->name,
                        'debit' => $lg->debit,
                        'balance' => $lg->balance,
                    ];
                    $own[] = $owner->id;
                }
            }
        }
        foreach (array_unique($own) as $owner) {
            $owner_ledger = PurchaseLedger::where('to', $id)->where('by', $owner)->get();
            $ownerData = owner::where('id', $owner)->first();
            $debit = 0;
            $credit = 0;
            foreach ($owner_ledger as $ob) {
                $debit =  $debit + $ob->debit;
                $credit = $credit + $ob->credit;
            }
            $owner_balance[] = ['owner_id' => $ownerData->id, 'owner' => $ownerData->name, 'balance' => $debit - $credit];
        }

        $netData = ['id' => $vender->id, 'vender' => $vender->name, 'latestBalance' => $latestBalance->balance, 'ledger' => $data, 'owner_balance' => $owner_balance];
        return view('pages.purchase.purchasePayment')
            ->with('purchasPayments', $purchasPayments)
            ->with('banks', $banks)
            ->with('netData', $netData);
    }

    public function purchasePayment(Request $request, $owner_id, $vendor_id)
    {
        $latestBalance = PurchaseLedger::latest()->first();
        PurchaseLedger::create([
            'by' => $owner_id,
            'to' => $vendor_id,
            'debit' => 0,
            'credit' => $request->amount + $request->discount,
            'balance' => $latestBalance->balance - ($request->amount + $request->discount),
        ]);
        $PL = PurchaseLedger::latest()->first();
        $photo = $request->file('docs');
        $doc_path = '';
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/payment-docs', $doc_name);
        }

        PurchsePayment::create([
            'date' => $request->date,
            'amount'    => $request->amount,
            'discount'  => $request->discount,
            'refrence_no'   => $request->refrence_no,
            'payment_type'  => $request->payment_type,
            'BankName'  => $request->bank,
            'Docs'  => $doc_path,
            'Remarks'   => $request->remark,
            'owner_id' => $owner_id,
            'vendor_id' => $vendor_id,
            'PL_id' => $PL->id,
        ]);

        return back()->with('success', 'Transaction Done.');
    }

    public function editPurchasePayment(Request $request, $id)
    {
        $payment =  PurchsePayment::where('id', $id)->first();
        $lg =  PurchaseLedger::where('id', $payment->PL_id)->first();
        $owner_ledger =  PurchaseLedger::where('id', '>', $payment->PL_id)->get();
        $def = $payment->amount - ($request->amount + $request->discount);

        //update after the updated lager id to latest one.
        foreach ($owner_ledger as $ledger) {
            PurchaseLedger::where('id', $ledger->id)->update([
                'balance' => $ledger->balance - (-$def),
            ]);
        }
        PurchaseLedger::where('id', $payment->PL_id)->update([
            'credit' => $request->amount + $request->discount,
            'balance' => $lg->balance - (-$def),
        ]);

        $photo = $request->file('docs');
        $doc_path = '';
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/payment-docs', $doc_name);
        } else {
            $doc_path = $payment->Docs;
        }
        PurchsePayment::where('id', $id)->update([
            'date' => $request->date,
            'amount'    => $request->amount,
            'discount'  => $request->discount,
            'refrence_no'   => $request->refrence_no,
            'payment_type'  => $request->payment_type,
            'BankName'  => $request->bank,
            'Docs'  => $doc_path,
            'Remarks'   => $request->remark,
        ]);

        return back()->with('success', 'Transaction Updated.');
    }

    public function deletePurchasePayment($id)
    {
        $payment =  PurchsePayment::where('id', $id)->first();
        $lg =  PurchaseLedger::where('id', $payment->PL_id)->first();
        $owner_ledger =  PurchaseLedger::where('id', '>', $payment->PL_id)->get();

        foreach ($owner_ledger as $ledger) {
            PurchaseLedger::where('id', $ledger->id)->update([
                'balance' => $ledger->balance + ($payment->amount + $payment->discount),
            ]);
        }

        $lg->delete();
        $payment->delete();

        return back()->with('success', 'Transaction Deleted.');
    }

    public function vendorPurchaseHistory($id)
    {
        $purchaseOrder = PurchaseOrder::where('vender', $id)->orderBy('created_at', 'desc')->get();
        $vendor = Vendor::find($id);
        $data = [];
        foreach ($purchaseOrder as $po) {
            $pods = PurchaseOrderDetail::where('purchase_order_id', $po->id)->get();
            foreach ($pods as $pod) {
                $item = Item::find($pod->item_id);
                if (!empty($item)) {
                    $pod_data[] = [
                        'order_id' => $pod->purchase_order_id,
                        'item_id' => $item->id,
                        'item_code' => $item->product_code,
                        'quantity' => $pod->qunatity,
                        'total' => $pod->amount,
                        'tax' => $pod->tax,
                        'grand_total' => $pod->total,
                    ];
                }
            }
            $location = BusinessLocation::find($po->business_location);
            $owner = Owner::find($po->owner);
            if (!empty($item)) {
                if (!empty($item)) {
                    $data[] = [
                        'id' => $po->id,
                        'date' => $po->created_at,
                        'RF' => $po->reference_number,
                        'location' => $location->name,
                        'owner' => $owner->name,
                        'payment_terms' => $po->payment_terms,
                        'total_payment' => $po->total_payment,
                        'Details' => $pod_data
                    ];
                }
            }
        }
        return view('pages.purchase.vendorPurchaseHistory')
            ->with('vendor', $vendor->name)
            ->with('data', $data);
    }
}
