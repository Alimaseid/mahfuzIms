<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function addRole(Request $request)
    {
        // 1️⃣ Reject reused tokens
        $exists = DB::table('request_tokens')
            ->where('token', $request->request_token)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Duplicate submission blocked.');
        }

        // 2️⃣ Store token immediately so duplicates are blocked
        DB::table('request_tokens')->insert([
            'token' => $request->request_token,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $role = Role::create([
            'role_name' => $request->role_name,
            'manage_user' => $request->manage_user,
            'manage_edit_user' => $request->manage_edit_user,
            'manage_delete_user' => $request->manage_delete_user,

            'manage_location' => $request->manage_location,
            'manage_edit_location' => $request->manage_edit_location,
            'manage_delete_location' => $request->manage_delete_location,

            'manage_item_unit' => $request->manage_item_unit,
            'manage_edit_itemUnit' => $request->manage_edit_itemUnit,
            'manage_delete_itemUnit' => $request->manage_delete_itemUnit,

            'manage_item' => $request->manage_item,
            'manage_edit_item' => $request->manage_edit_item,
            'manage_delete_item' => $request->manage_delete_item,
            'set_item_price' => $request->set_item_price,

            'manage_category' => $request->manage_category,
            'manage_edit_category' => $request->manage_edit_category,
            'manage_delete_category' => $request->manage_delete_category,

            'manage_shelf' => $request->manage_shelf,
            'manage_edit_shelf' => $request->manage_edit_shelf,
            'manage_delete_shelf' => $request->manage_delete_shelf,

            'manage_customer' => $request->manage_customer,
            'manage_edit_customer' => $request->manage_edit_customer,
            'manage_delete_customer' => $request->manage_delete_customer,
            'manage_dailycustomerReport' => $request->manage_dailycustomerReport,
            'manage_customer_history' => $request->manage_customer_history,

            'manage_good_receiving' => $request->manage_good_receiving,
            'manage_edit_goodreceiving' => $request->manage_edit_goodreceiving,
            'manage_delete_goodreceiving' => $request->manage_delete_goodreceiving,

            'manage_sales' => $request->manage_sales,
            'manage_edit_sales' => $request->manage_edit_sales,
            'manage_delete_sales' => $request->manage_delete_sales,
            'manage_dailysalesReport' => $request->manage_dailysalesReport,
            'manage_shopStock_reports' => $request->manage_shopStock_reports,
            'manage_shopTRansferReports' => $request->manage_shopTRansferReports,

            'manage_item_transfer' => $request->manage_item_transfer,
            'manage_itemTransfer_delete' => $request->manage_itemTransfer_delete,

            'manage_disposal' => $request->manage_disposal,
            'manage_edit_disposal' => $request->manage_edit_disposal,
            'manage_delete_disposal' => $request->manage_delete_disposal,

            'manage_activity_log' => $request->manage_activity_log,
            'approval' => $request->approval,

            'manage_stock_reports' => $request->manage_stock_reports,
            'manage_notification' => $request->manage_notification,
            'manage_storeTRansferReports' => $request->manage_storeTRansferReports
        ]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties(['data' => $role->toArray()])
            ->log('Added a new role');

        return back()->with('success', 'New Role Added.');
    }

    public function editRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update($request->except('_token'));

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties(['data' => $role->toArray()])
            ->log('Edited a role');

        return back()->with('success', 'Role Updated.');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        // ✅ Log activity before delete
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties(['data' => $role->toArray()])
            ->log('Deleted a role');

        $role->delete();

        return back()->with('success', 'Role Deleted.');
    }

    public function setRole(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->role;
        $oldRole = $user->role;
        $user->role = $request->role;
        $user->update();

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'old_role' => $oldRole,
                'new_role' => $request->role
            ])
            ->log('Changed user role');

        return back()->with('success', 'Set Role Succeed.');
    }
}
