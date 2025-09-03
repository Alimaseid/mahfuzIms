<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Owner;
use App\Models\Issuing;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\SalesPayment;
use Illuminate\Http\Request;
use App\Models\IssuingDetail;
use App\Models\PaymentLedger;
use App\Models\BusinessLocation;
use App\Http\Requests\StoreSalesPaymentRequest;
use App\Http\Requests\UpdateSalesPaymentRequest;

class SalesPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = SalesPayment::orderBy('created_at','desc')->get();
        $customers = Customer::all();
        $owners = Owner::all();
        $payment_counter = count(SalesPayment::all());
        return view('pages.sales.payments')
        ->with('customers',$customers)
        ->with('owners',$owners)
        ->with('payments',$payments)
        ->with('payment_counter',$payment_counter);
    }
    public function addSalesPayment(Request $request,$order_id,$customer_id,$location_id,$owner_id){
        $doc_path= '';
        $photo = $request->file('banck_receipt');
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/BankReciepts',$doc_name);
         }
        SalesPayment::create([
            'order_id' =>$order_id,
            'owner_id' =>$owner_id,
            'location_id' =>$location_id,
            'customer_id' =>$customer_id,
            'amount' =>$request->amount,
            'payment_type' =>$request->payment_type,
            'cheque_no' =>$request->cheque_no,
            'banck_receipt' =>$doc_path,
        ]);
        $order = SalesOrder::where('id',$order_id)->first();
        $credit = $order->grand_total - $request->amount;
        if( $credit == 0){
            SalesOrder::where('id',$order_id)->update([
                    'payment_status' => 'Paid',
                    'grand_total' => $credit,
            ]);
        }elseif($credit > 0){
            SalesOrder::where('id',$order_id)->update([
                'payment_status' => 'Partialy Paid',
                'grand_total' => $credit,
             ]);
        }else{
            SalesOrder::where('id',$order_id)->update([
                'payment_status' => 'Over Paid',
                'grand_total' => $credit,
        ]);
        }

        $latest_ladger = PaymentLedger::where('customer_id',$customer_id)->latest()->first();
        PaymentLedger::create([
        'date' => Carbon::now(),
        'customer_id' => $customer_id,
        'narration' => $order->id,
        'voucher_no' => rand(100000, 999999),
        'voucher_type' => $request->payment_type,
        'debit' => 0,
        'credit' => $request->amount,
        'running_balance' => $latest_ladger->running_balance - $request->amount,
        ]);
        return back()->with('success','Saved.');
    }

    public function editSalesPayment(Request $request,$id){
        $payment = SalesPayment::where('id',$id)->first();
        $doc_path= $payment->banck_receipt;

        $photo = $request->file('banck_receipt');
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/BankReciepts',$doc_name);
         }
        SalesPayment::where('id',$id)->update([
            'amount' =>$request->amount,
            'payment_type' =>$request->payment_type,
            'cheque_no' =>$request->cheque_no,
            'banck_receipt' =>$doc_path,
        ]);

        $change = $payment->amount - $request->amount;
        $order = SalesOrder::where('id',$payment->order_id)->first();
        $credit = $order->grand_total - (-$change);
        if( $credit == 0){
            SalesOrder::where('id',$payment->order_id)->update([
                    'payment_status' => 'Paid',
                    'grand_total' => $credit,
            ]);
        }elseif($credit > 0){
            SalesOrder::where('id',$payment->order_id)->update([
                'payment_status' => 'Partialy Paid',
                'grand_total' => $credit,
             ]);
        }else{
            SalesOrder::where('id',$payment->order_id)->update([
                'payment_status' => 'Over Paid',
                'grand_total' => $credit,
        ]);
        }
        return back()->with('success','Updated.');

    }

    Public function deleteSalesPayment($id){
        $payment = SalesPayment::where('id',$id)->first();
        $order = SalesOrder::where('id',$payment->order_id)->first();
        $credit = $order->grand_total + $payment->amount;
        SalesOrder::where('id',$payment->order_id)->update([
            'grand_total' => $credit,
        ]);
        SalesOrder::where('id', $id)->delete();
        if( $credit == 0){
            SalesOrder::where('id',$payment->order_id)->update([
                    'payment_status' => 'Paid',
            ]);
        }elseif($credit > 0){
            SalesOrder::where('id',$payment->order_id)->update([
                'payment_status' => 'Partialy Paid',
             ]);
        }else{
            SalesOrder::where('id',$payment->order_id)->update([
                'payment_status' => 'Over Paid',
        ]);
        }
        return back()->with('success','Updated.');
    }

    public function customerSalesHistory($id){
        $issue = Issuing::where('id',1)->first();
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
        return view('pages.sales.customerSalesHistory')->with('data', $data);
    }


}
