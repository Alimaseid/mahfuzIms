<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BankList;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\PaymentLedger;
use App\Models\SalesOrderDetail;
use App\Http\Requests\StorePaymentLedgerRequest;
use App\Http\Requests\UpdatePaymentLedgerRequest;

class PaymentLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.payment.payments');
    }

    public function customerPayments($id){
         $payments = PaymentLedger::orderBy('created_at','desc')->where('customer_id', $id)->get();
         $lastBalance = PaymentLedger::orderBy('created_at','desc')->where('customer_id', $id)->latest()->first();
         $customer = Customer::find($id);
         $salesOrders = SalesOrder::where('customer_id', $id)->get();
         $salesOrderDetails = SalesOrderDetail::all();
         $banks = BankList::all();
         $debit = 0;
         $credit = 0;
         foreach ($payments as $payment) {
            if($payment->status != 'Approved') {
                if($payment->debit == 0){
                    $credit = $credit + $payment->credit;
                }else{
                    $debit = $debit + $payment->debit;
                }
            }
         }
         $approved_payment = $debit - $credit;
         if($lastBalance != null) {
             return view('pages.payment.payments')
             ->with('banks', $banks)
             ->with('customer', $customer->name)
             ->with('payments', $payments)
             ->with('lastBalance', $lastBalance)
             ->with('salesOrders', $salesOrders)
             ->with('salesOrderDetails', $salesOrderDetails)
             ->with('approved_payment',$approved_payment);
            }else{
                return back()->with('error',$customer->name.' Not Have Balance Details');
            }
    }

    public function editCustomerPayment(Request $request,$id){

        $payment = PaymentLedger::where('id', $id)->first();
        $customer = Customer::find($payment->customer_id);

        $def = $payment->credit - $request->amount;

        $doc_path= $payment->voucher_no;
        $photo = $request->file('banck_receipt');
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/BankReciepts',$doc_name);
         }
        PaymentLedger::where('id',$id)->update([
        'voucher_no' => $doc_path,
        'voucher_type' => $request->payment_type.','.$request->bank,
        'refrence_no' => $request->cheque_no,
        'debit' => 0,
        'credit' => $request->amount,
        'running_balance' => $payment->running_balance - (-$def),
        ]);


        $newPayments = PaymentLedger::where('id','>', $id)->get();
        foreach($newPayments as $update){
            PaymentLedger::where('id',$update->id)->update([
              'running_balance' => $update->running_balance - (-$def),
            ]);
        }

        $customer->total_balance =  $customer->total_balance - (-$def);
        $customer->save();

        return back()->with('success','Payment Update Successful.');
    }

    public function payment(Request $request,$id){
        $customer = Customer::find($id);

        $doc_path= '';
        $photo = $request->file('banck_receipt');
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/BankReciepts',$doc_name);
         }
        PaymentLedger::create([
        'date' => Carbon::now(),
        'customer_id' => $id,
        'voucher_no' => $doc_path,
        'voucher_type' => $request->payment_type.','.$request->bank,
        'refrence_no' => $request->cheque_no,
        'debit' => 0,
        'credit' => $request->amount,
        'running_balance' => $customer->total_balance  - $request->amount,
        ]);

        $customer->total_balance =  $customer->total_balance - $request->amount;
        $customer->save();
        // if($request->payment_type == 'Cash'){
        //    $payment =  PaymentLedger::latest()->first();
        //    PaymentLedger::where('id',$payment->id)->update(['status' => 'Approved']);
        // }

        return back()->with('success','Payment Registration Successful.');
    }

    public function paymentApproval(){
        $payments  = PaymentLedger::where('status','Pending')->where('debit','=',0)->orderBy('created_at','desc')->get();
        $customers = Customer::all();
        return view('pages.payment.payment_approval')
        ->with('customers', $customers)
        ->with('payments', $payments);
    }

    public function addNewBank(Request $request){
        BankList::create([
            'BankName' => $request->bankname,
            'AccountNumber' => $request->account,
            'Label' => $request->label,
        ]);
        return back()->with('success','Bank Name add toBank List Success.');
    }

    public function approvePayment($id){
        PaymentLedger::where('id', $id)->update(['status' => 'Approved']);
        return back()->with('success','Transaction Approved Succeed.');

    }

    public function rejectPayment($id){
        $pay = PaymentLedger::find($id);
        $customer = Customer::find($pay->customer_id);

        $affectd_ledger = PaymentLedger::where('id','>', $id)->get();
        foreach($affectd_ledger as $affectd){
            PaymentLedger::where('id',$affectd->id)->update([
              'running_balance' => $affectd->running_balance +  $pay->credit,
            ]);
        }



        $customer->total_balance =  $customer->total_balance + $pay->credit;
        $customer->save();
        $pay->delete();
        return back()->with('success','Transaction Rejected Succeed.');
    }

    public function purchasePayment(){
        return view('pages.purchase.managePayments');
    }

}
