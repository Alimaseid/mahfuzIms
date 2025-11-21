<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.user.users')
            ->with('roles', $roles)
            ->with('permission', $permission)
            ->with('users', $users);
    }

    public function addUser(Request $request)
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
        $user = User::create([
            'name'     => $request->full_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make(12345678),
        ]);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name'  => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ])
            ->log('Added a new User');

        return back()->with('success', 'Register Succeed !!');
    }

    // ✅ Edit User
    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'  => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'new_name' => $request->full_name,
                'new_email' => $request->email,
                'new_phone' => $request->phone,
            ])
            ->log('Edited User');

        return back()->with('success', 'Edit User Succeed !!');
    }

    // ✅ Delete User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Log before delete
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
            ])
            ->log('Deleted User');
        $user->delete();
        return back()->with('success', 'Delete User Succeed !!');
    }
}
