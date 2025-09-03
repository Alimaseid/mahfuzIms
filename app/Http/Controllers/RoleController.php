<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function addRole(Request $request){
        Role::create([
            'role_name' =>$request->role,
            'manage_user' =>$request->manage_user,
            'manage_item' =>$request->manage_item,
            'manage_vendor' =>$request->manage_vendor,
            'manage_purchase' =>$request->manage_purchase,
            'manage_customer' =>$request->manage_customer,
            'manage_customer_history' =>$request->manage_customer_history,
            'manage_sales' =>$request->manage_sales,
            'manage_order' =>$request->manage_order,
            'manage_store_issue' =>$request->manage_store_issue,
            'approval' =>$request->approval,
            'reports' =>$request->reports
        ]);
        return back()->with('success','New Role Added.');
    }
    public function editRole(Request $request,$id){
        Role::where('id',$id)->update([
            'manage_user' =>$request->manage_user,
            'manage_item' =>$request->manage_item,
            'manage_vendor' =>$request->manage_vendor,
            'manage_purchase' =>$request->manage_purchase,
            'manage_customer' =>$request->manage_customer,
            'manage_customer_history' =>$request->manage_customer_history,
            'manage_sales' =>$request->manage_sales,
            'manage_order' =>$request->manage_order,
            'manage_store_issue' =>$request->manage_store_issue,
            'approval' =>$request->approval,
            'reports' =>$request->reports
        ]);
        return back()->with('success','Role Updated.');
    }
    public function deleteRole($id){
        Role::where('id',$id)->delete();
        return back()->with('success','Role Deleted.');
    }

    public function setRole(Request $request,$id){
        User::where('id',$id)->update(['role' =>$request->role]);
        return back()->with('success','Set Role Succeed.');


    }

}
