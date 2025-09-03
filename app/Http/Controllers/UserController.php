<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $roles = Role::orderBy('created_at','desc')->get();
        $users = User::orderBy('created_at','desc')->get();

        return view('pages.user.users')
        ->with('roles',$roles)
        ->with('users',$users);
    }

    public function addUser(Request $request){
        User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make(12345678),
        ]);

        return back()->with('success','Register Succeed !!');
    }

    public function editUser(Request $request,$id){
        User::where('id',$id)->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            // 'password' => Hash::make(12345678),
        ]);

        return back()->with('success','Edit User Succeed !!');
    }

    public function deleteUser($id){
        User::where('id',$id)->delete();
        return back()->with('success','delete User Succeed !!');
    }
}
