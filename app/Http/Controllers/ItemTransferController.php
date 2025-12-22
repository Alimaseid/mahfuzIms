<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemOnShop;
use Illuminate\Support\Str;
use App\Models\ItemTransfer;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreItemTransferRequest;
use App\Http\Requests\UpdateItemTransferRequest;
use App\Models\Inventory;
use App\Models\ItemOwner;
use App\Models\ItemShelf;
use App\Models\Owner;
use App\Models\Requisition;
use App\Models\RequisitionDetail;
use App\Models\Role;
use App\Models\User;

class ItemTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = BusinessLocation::all();
        $transfers = ItemTransfer::orderBy('created_at', 'desc')->get();
        return view('pages.store.iterm_transfer')
            ->with('transfers', $transfers)
            ->with('locations', $locations);
    }

    public function requisites()
    {
        $locations = BusinessLocation::all();
        $requisitions = Requisition::with('itemList')
            ->orderBy('id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(200);

        $requisitionDetails = RequisitionDetail::all();
        $items = Inventory::with(['item', 'location'])->get();
        $shelfs = ItemShelf::all();
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.store.iterm_transfer', compact('items', 'requisitions', 'locations', 'requisitionDetails', 'shelfs', 'permission'));
    }

    public function getItemForSale(Request $request)
    {
        $locationId = $request->location_id;

        $items = Inventory::with('item')
            ->where('location_id', $locationId) // ✅ filter by location
            ->where('quantity', '>', 0)         // only available stock
            ->get()
            ->map(function ($inv) {
                return [
                    'id' => $inv->item->id,
                    'item_name' => $inv->item->name,
                    'product_code' => $inv->item->product_code,
                    'batch_number' => $inv->batch->batch_number,
                    'quantity' => $inv->quantity,
                    'batch_id' => $inv->batch_id,
                    'image' => $inv->item->image,
                ];
            });

        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveRequisition()
    {
        $requisitionDetails = RequisitionDetail::all();
        $shelfs = ItemShelf::all();
        $requisitions =  Requisition::orderBy('id', 'desc')->with('itemList')->where('status', 'Pending')->get();
        $user = User::where('id', Auth::user()->id)->first();
        $permission = Role::where('id', $user->role)->first();
        return view('pages.store.approve_requisition')->with('requisitions', $requisitions)->with('permission', $permission)->with('shelfs', $shelfs)->with('requisitionDetails', $requisitionDetails);
    }
    public function approve($id, $user)
    {
        $requisition = Requisition::with('itemList')->findOrFail($id);

        $fromLoc = $requisition->request_from; // must be ID
        $toLoc   = $requisition->request_to;   // must be ID

        foreach ($requisition->itemList as $detail) {
            $itemId   = $detail->item_id;
            $quantity = $detail->quantity;
            $batch = $detail->batch_id;

            // Reduce stock in source location
            $fromInventory = Inventory::where('item_id', $itemId)
                ->where('location_id', $fromLoc)
                ->where('batch_id', $batch)
                ->first();

            if ($fromInventory) {
                $fromInventory->quantity = max(0, $fromInventory->quantity - $quantity);
                $fromInventory->save();
            }

            // Increase stock in destination location
            $toInventory = Inventory::where('item_id', $itemId)
                ->where('location_id', $toLoc)
                ->where('batch_id', $batch)
                ->first();

            if ($toInventory) {
                $toInventory->quantity += $quantity;
                $toInventory->save();
            } else {
                Inventory::create([
                    'item_id'     => $itemId,
                    'location_id' => $toLoc,
                    'batch_id' => $batch,
                    'quantity'    => $quantity,
                ]);
            }
        }
        $requisition->transfer_by = $user;
        $requisition->status = 'Approved';
        $requisition->update();



        return back()->with('success', 'Approved and inventory updated.');
    }




    public function issueRequisition()
    {
        $locations = BusinessLocation::all();
        $owners = Owner::all();
        $requisitions =  Requisition::orderBy('id', 'desc')->with('itemList')->where('status', 'Approved')->get();
        return view('pages.issuing.issue_requisition')
            ->with('locations', $locations)
            ->with('owners', $owners)
            ->with('requisitions', $requisitions);
    }

    public function issueRequisitionSave(Request $request, $id)
    {
        $requisition =  Requisition::find($id);
        Requisition::where('id', $id)->update([
            'issued_by' => $request->issued_by,
            'ship_by' => $request->ship_by,
            'transfer_from_store' => $request->transfer_from_store,
            'status' => 'Shipped',
        ]);


        foreach ($request->addmore as $key => $item_list) {
            RequisitionDetail::where('id', $key)->update([
                'owner_id' => $item_list['transfer_from_owner'],
            ]);
            $loc = BusinessLocation::WHERE('name', $requisition->request_from)->first();

            $item_on_shop = ItemOnShop::where('location_name', $requisition->request_from)->where('item_id', $item_list['item_id'])->first();
            if ($item_on_shop == null) {
                ItemOnShop::create(
                    [
                        'item_id' => $item_list['item_id'],
                        'item_name' => ($item_list['item_name']),
                        'location_id' => $loc->id,
                        'location_type' => $loc->type,
                        'location_name' => $loc->name,
                        'qauntity' => $item_list['quantity'],
                    ]
                );
            } else {
                $item_on_shop->qauntity = $item_on_shop->qauntity + $item_list['quantity'];
                $item_on_shop->save();
            }

            $from_item_owner = ItemOwner::where('item_id', $item_list['item_id'])
                ->where('owner_id', $item_list['transfer_from_owner'])
                ->where('location_id', $request->transfer_from_store)
                ->first();

            if ($from_item_owner != null) {
                $from_item_owner->quantity = $from_item_owner->quantity - $item_list['quantity'];
                $from_item_owner->save();
            }

            $to_item_owner = ItemOwner::where('item_id', $item_list['item_id'])
                ->where('owner_id', $item_list['transfer_from_owner'])
                ->where('location_id', $loc->id)
                ->first();
            if ($to_item_owner == null) {
                ItemOwner::create([
                    'owner_id' => $item_list['transfer_from_owner'],
                    'item_id' => $item_list['item_id'],
                    'item_name' => $item_list['item_name'],
                    'quantity' => $item_list['quantity'],
                    'location_id'   => $loc->id,
                ]);
            } else {
                $to_item_owner->quantity = $to_item_owner->quantity + $item_list['quantity'];
                $to_item_owner->save();
            }
        }

        return back()->with('success', 'Issuing Requisition Success');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            'request_from' => 'required',
            'request_to'   => 'required|different:request_from', // make sure request_to != request_from
        ]);

        $requisition = Requisition::create([
            'request_from' => $request->request_from,   // source location (warehouse)
            'request_to'   => $request->request_to,     // destination location (shop)
            'request_by'   => Auth::user()->name,
            'status'       => 'Pending',
        ]);

        foreach ($request->addmore as $item_list) {
            RequisitionDetail::create([
                'requisition_id' => $requisition->id,
                'item_id'        => $item_list['item_id'],
                'batch_id'        => $item_list['batch_id'],
                'quantity'       => $item_list['quantity'],
            ]);
        }

        return back()->with('success', 'Requisition created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(ItemTransfer $itemTransfer)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemTransfer $itemTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemTransferRequest  $request
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemTransferRequest $request, ItemTransfer $itemTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function deleteRequisition($id)
    {
        $requisition = Requisition::findOrFail($id);

        // delete all requisition details in one go
        RequisitionDetail::where('requisition_id', $id)->delete();

        // delete the requisition itself
        $requisition->delete();

        return back()->with('success', 'Requisition deleted successfully.');
    }

    public function printRequisition($id)
    {
        $requesition = Requisition::where('id', $id)->first();
        $reqDetails = RequisitionDetail::where('requisition_id', $requesition->id)->get();

        $invoice_data = [
            'requesition' => $requesition,
            'reqDetails' => $reqDetails
        ];
        // return $invoice_data;
        return view('pages.store.printTransfer')
            ->with('requesition', $requesition)
            ->with('reqDetails', $reqDetails);
    }
}
