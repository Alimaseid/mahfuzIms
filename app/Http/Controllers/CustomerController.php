<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\PaymentLedger;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('pages.customers.customer')
            ->with('customers', $customers);
    }

    public function addCustomer(Request $request)
    {
        $customer =  Customer::create([
            'name' => $request->name,
            'type' => $request->type,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tin' => $request->tin,
            'address' => $request->address,
            'total_balance' => 0,
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($customer)
            ->withProperties(['data' => $customer])
            ->log('Added new customer');

        $customer = Customer::latest()->first();
        PaymentLedger::create([
            'date' => Carbon::now(),
            'customer_id' => $customer->id,
            'debit' => 0,
            'credit' => 0,
            'running_balance' => 0,
        ]);
        return back()->with('success', 'Customer Registerd.');
    }

    public function editCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'type' => $request->type,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tin' => $request->tin,
            'address' => $request->address,
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($customer)
            ->withProperties(['data' => $customer])
            ->log('Edited new customer');
        return back()->with('success', 'Customer Registerd.');
    }

    public function searchCustomer(Request $request)
    {
        $customers = Customer::Where('name', 'like', '%' . $request->name . '%')
            ->orWhere('phone', 'like', '%' . $request->name . '%')
            // ->orWhere('tin','like','%'. $request->name.'%')
            ->get();
        return json_encode($customers);
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($customer)
            ->withProperties(['data' => $customer])
            ->log('Deleted new customer');
        return back()->with('success', ' Item Deleted Successfully.');
    }
}
