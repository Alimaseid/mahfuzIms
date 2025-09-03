<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Owner;
use App\Models\Vendor;
use App\Models\Issuing;
use App\Models\Customer;
use App\Models\ItemOwner;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\IssuingDetail;
use App\Models\BusinessLocation;
use App\Models\PaymentLedger;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class IssuingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesOrders = SalesOrder::where('SM_status','Accepted')->orderBy('id', 'desc')->get();
    // return $salesOrders;
        // $salesOrder = SalesOrder::all();
        $vendors = Vendor::all();
        $warehouses = BusinessLocation::where('type','Warehouse')->get();
        $businessLocations = BusinessLocation::all();
        $owners = Owner::all();
        $items = Item::all();
        $salesOrderDetails = SalesOrderDetail::all();
        $customers = Customer::all();
        $issues = Issuing::latest()->take(15)->get();
        $issue_detail = IssuingDetail::all();
        return view('pages.issuing.issuing')
        ->with('issues', $issues)
        ->with('issue_detail', $issue_detail)
        ->with('warehouses', $warehouses)
        ->with('owners', $owners)
        ->with('customers', $customers)
        ->with('businessLocations', $businessLocations)
        ->with('items', $items)
        ->with('vendors', $vendors)
        // ->with('salesOrder', $salesOrder)
        ->with('salesOrderDetails', $salesOrderDetails)
        ->with('salesOrders', $salesOrders);
    }


    public function addIssuing(Request $request){
        Issuing::create([
            'issued_from'   =>$request->from,
            'voucher_number'  =>$request->refrence_no,
            'issued_by'  =>Auth::user()->id,
            'issued_to'  =>$request->to,
            'owner_Id'  =>$request->owner,
            'date' => Carbon::now()->toDateString(),
            'issuing_detail_id'   =>1,
        ]);

        $issuie = Issuing::select('id')->latest()->first();
        $total = 0;
        foreach($request->addmore as $list){
            $total = $total + $list['quantity'];
            $item = Item::where('id',Str::of($list['search_item'])->before(','))->first();
            if($item != null){
                $item_to_owner = ItemOwner::where('item_id',$item->id)
                ->where('owner_id',$request->owner)
                ->where('location_id',$request->from)
                ->where('quantity','>',0)
                ->first();

                $newLocation = ItemOwner::where('item_id',$item->id)
                ->where('owner_id',$request->owner)
                ->where('location_id',$request->to)
                ->first();
            }else{
                return back()->with('error',Str::of($list['search_item'])->after(',').'is Not Found On '.Auth::user()->name.'`s Item List.');
            }
            if($item_to_owner != null){
                IssuingDetail::create([
                    'item_id' => $item->id,
                    'issuing_id' =>$issuie->id,
                    'item_name'=>$item->item_name,
                    'qauntity'=> $list['quantity'],
                ]);
                ItemOwner::where('item_id',$item->id)
                ->where('owner_id',$request->owner)
                ->where('location_id',$request->from)
                ->update(['quantity' =>$item_to_owner->quantity - $list['quantity']]);
                if(empty($newLocation)){
                    ItemOwner::create([
                        'owner_id' =>$request->owner,
                        'item_id'=>$item->id,
                        'item_name'=>$item->item_name,
                        'location_id'=> $request->to,
                        'quantity'=>$list['quantity'],
                     ]);
                }else{
                    ItemOwner::where('item_id',$item->id)
                    ->where('owner_id',$request->owner)
                    ->where('location_id',$request->to)
                    ->update(['quantity' =>$item_to_owner->quantity + $list['quantity']]);
                }

            }else{
                return back()->with('error',Str::of($list['search_item'])->after(',').'is Not Found On '.Auth::user()->name.'`s Item List.');

            }
        }
        $issuie->issuing_detail_id = $total;
        $issuie->save();
        return back()->with('success','Save.');
    }


    public function printIssue($id){
        $issue = Issuing::where('id',$id)->first();
        $owner = Owner::where('id',$issue->owner_Id)->first();
        $locaion_from = BusinessLocation::where('id',$issue->issued_from)->first();
        $locaion_to = BusinessLocation::where('id',$issue->issued_to)->first();
        $user = User::where('id',$issue->issued_by)->first();

        $data [] = [
            'Owner' => $owner->name,
            'From' => $locaion_from->name,
            'To' => $locaion_to->name,
            'IssuedBy' => $user->name,
            'Vno' => $issue->voucher_number,
            'Quantity' => $issue->issuing_detail_id,
            'ItemList' => IssuingDetail::where('issuing_id',$id)->get()
        ];

        return view('pages.issuing.printIssuing')->with('data',$data);
    }

    public function deleteIssuing($id){
        $issue = Issuing::where('id',$id)->first();
        $issue_detail = IssuingDetail::where('issuing_id',$issue->id)->get();
        foreach($issue_detail as $detail){
            $to = ItemOwner::where('item_id',$detail->item_id)->where('owner_id',$issue->owner_Id)->where('location_id',$issue->issued_to)->first();
            $from = ItemOwner::where('item_id',$detail->item_id)->where('owner_id',$issue->owner_Id)->where('location_id',$issue->issued_from)->first();

            ItemOwner::where('item_id',$detail->item_id)
            ->where('owner_id',$issue->owner_Id)
            ->where('location_id',$issue->issued_to)
            ->update(['quantity' =>$to->quantity - $detail->qauntity]);

            ItemOwner::where('item_id',$detail->item_id)
            ->where('owner_id',$issue->owner_Id)
            ->where('location_id',$issue->issued_from)
            ->update(['quantity' =>$from->quantity + $detail->qauntity]);
        }
        Issuing::where('id',$id)->delete();
        return back()->with('success','Deleted.');
    }

    public function getItemOwnerBalance(Request $request){
       $data = ItemOwner::where('item_id',$request->item)->where('owner_id',$request->owner)->where('location_id',$request->location)->first();
       return json_encode($data);
    }

    public function getItemForIssue(Request $request){
        $data = ItemOwner::where('owner_id',$request->owner_id)->where('location_id',$request->location_id)->get();
        $mydata = [];
        foreach($data as $d){
            $item = Item::where('id',$d->item_id)->first();
            $mydata [] = ['id'=>$d->id,'item_id' => $item->id, 'item_code' => $item->product_code,'quantity'=>$item->quantity];
        }
        return json_encode($mydata);
    }

    public function addOrderIssuing(Request $request,$id){
        Issuing::create([
            'issued_from'   =>$request->from,
            'voucher_number'  =>$request->refrence_no,
            'issued_by'  =>Auth::user()->id,
            'issued_to'  =>$request->to,
            'date' => $request->issue_date,
            'issuing_detail_id'   =>1,
        ]);

        $issuie = Issuing::select('id')->latest()->first();
        $total = 0;

        foreach($request->addmore as $list){
            $total = $total + $list['quantity'];
            $item = Item::where('id',$list['item_id'])->first();
            if($item != null){
                $item_to_owner = ItemOwner::where('item_id',$item->id)
                ->where('owner_id',$list['owner'])
                ->where('location_id',$request->from)
                ->where('quantity','>',0)
                ->first();
            }else{
                IssuingDetail::where('issuing_id',$issuie->id)->delete();
                $owner = Owner::where('id',$list['owner'])->first();
                $issuie->delete();
                return back()->with('error',$list['item_name'].' - is Not Found On Items List.');
            }
            if($item_to_owner != null){
                IssuingDetail::create([
                    'item_id' => $item->id,
                    'issuing_id' =>$issuie->id,
                    'item_name'=>$item->product_code,
                    'owner_id'=>$list['owner'],
                    'qauntity'=> $list['quantity'],
                ]);
                ItemOwner::where('item_id',$item->id)
                ->where('owner_id',$list['owner'])
                ->where('location_id',$request->from)
                ->update(['quantity' =>$item_to_owner->quantity - $list['quantity']]);

                SalesOrderDetail::where('sales_order_id',$id)
                ->where('item_id',$item->id)
                ->update(['owner_id' => $list['owner'],'status'=>'approved']);
            }else{
                $owner = Owner::where('id',$list['owner'])->first();
                $issuie->delete();
                return back()->with('error',$list['item_name'].' - is Not Found On *'.$owner->name.'`s * Item List.');
            }
        }

        if($request->addmoreSup != ''){
            foreach($request->addmoreSup as $list){
                $total = $total + $list['quantity'];
                $item = Item::where('id',$list['item_id'])->first();
                // return $request->as
                if($item != null){
                    $item_to_owner = ItemOwner::where('item_id',$item->id)
                    ->where('owner_id',$list['owner'])
                    ->where('location_id',$list['location'])
                    ->where('quantity','>',0)
                    ->first();
                }else{
                    IssuingDetail::where('issuing_id',$issuie->id)->delete();
                    $owner = Owner::where('id',$list['owner'])->first();
                    $issuie->delete();
                    return back()->with('error',$list['item_name'].' - is Not Found On Items List.');
                }
                if($item_to_owner != null){
                    IssuingDetail::create([
                        'item_id' => $item->id,
                        'issuing_id' =>$issuie->id,
                        'item_name'=>$item->product_code,
                        'owner_id'=>$list['owner'],
                        'qauntity'=> $list['quantity'],
                    ]);
                    ItemOwner::where('item_id',$item->id)
                    ->where('owner_id',$list['owner'])
                    ->where('location_id',$list['location'])
                    ->update(['quantity' => $item_to_owner->quantity - $list['quantity']]);

                     SalesOrderDetail::where('sales_order_id',$id)
                     ->where('item_id',$item->id)
                     ->update(['owner_id' => $list['owner'],'status'=>'approved']);

                }else{
                    $owner = Owner::where('id',$list['owner'])->first();
                    $issuie->delete();
                    return back()->with('error',$list['item_name'].' - is Not Found On *'.$owner->name.'`s * Item List.');
                }
            }
        }
        $issuie->issuing_detail_id = $total;
        $issuie->save();
        SalesOrder::where('id',$id)->update(['SM_status' => 'Shipping']);
        PaymentLedger::where('narration',$id)->update(['status' => 'OnProccess']);
        return back()->with('success','Save.');
    }

    public function returnIssue($id){
        $sales = SalesOrder::find($id);
        $sales->SM_status = 'Pending';
        $sales->save();


        return back()->with('success','Order Back To Srore Manager');
    }
}
