<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function addRole(Request $request)
    {
        $role = Role::create([
            'role_name' => $request->role,
            'manage_user' => $request->manage_user,
            'manage_item' => $request->manage_item,
            'manage_vendor' => $request->manage_vendor,
            'manage_purchase' => $request->manage_purchase,
            'manage_customer' => $request->manage_customer,
            'manage_customer_history' => $request->manage_customer_history,
            'manage_sales' => $request->manage_sales,
            'manage_order' => $request->manage_order,
            'manage_store_issue' => $request->manage_store_issue,
            'approval' => $request->approval,
            'reports' => $request->reports
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

        $role->update([
            'manage_user' => $request->manage_user,
            'manage_item' => $request->manage_item,
            'manage_vendor' => $request->manage_vendor,
            'manage_purchase' => $request->manage_purchase,
            'manage_customer' => $request->manage_customer,
            'manage_customer_history' => $request->manage_customer_history,
            'manage_sales' => $request->manage_sales,
            'manage_order' => $request->manage_order,
            'manage_store_issue' => $request->manage_store_issue,
            'approval' => $request->approval,
            'reports' => $request->reports
        ]);

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

        $oldRole = $user->role;

        $user->update(['role' => $request->role]);

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
