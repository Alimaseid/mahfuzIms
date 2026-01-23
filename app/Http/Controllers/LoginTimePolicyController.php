<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginTimePolicy;
use Illuminate\Http\Request;

class LoginTimePolicyController extends Controller
{
    public function index()
    {
        $policy = LoginTimePolicy::where('active', true)->first();
        return view('index', compact('policy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'timezone'   => 'required'
        ]);

        LoginTimePolicy::where('active', true)->update(['active' => false]);

        LoginTimePolicy::create([
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'timezone'   => $request->timezone,
            'active'     => true,
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Login time policy updated successfully');
    }
}
