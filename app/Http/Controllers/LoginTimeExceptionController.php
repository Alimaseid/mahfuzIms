<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginTimeException;
use App\Models\User;
use Illuminate\Http\Request;

class LoginTimeExceptionController extends Controller
{
    public function index()
    {
        $exceptions = LoginTimeException::with('user')
            ->orderByDesc('allowed_from')
            ->get();

        $users = User::whereHas('roleRelation', function ($q) {
            $q->where('role_name', '!=', 'Super Admin');
        })->get();

        return view('loginException', compact('exceptions', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'allowed_from' => 'required|date',
            'allowed_to'   => 'required|date',
            'reason'       => 'nullable|string'
        ]);

        $this->validateOverlap($request);

        LoginTimeException::create([
            'user_id'      => $request->user_id,
            'allowed_from' => $request->allowed_from,
            'allowed_to'   => $request->allowed_to,
            'reason'       => $request->reason,
            'active'       => true,
            'created_by'   => auth()->id(),
        ]);

        return back()->with('success', 'Login exception created');
    }

    public function update(Request $request, LoginTimeException $exception)
    {
        $request->validate([
            'allowed_from' => 'required|date',
            'allowed_to'   => 'required|date',
            'reason'       => 'nullable|string',
            'active'       => 'required|boolean',
        ]);

        $this->validateOverlap($request, $exception->exception_id);

        $exception->update([
            'allowed_from' => $request->allowed_from,
            'allowed_to'   => $request->allowed_to,
            'reason'       => $request->reason,
            'active'       => $request->active,
        ]);

        return back()->with('success', 'Login exception updated');
    }

    public function toggle(LoginTimeException $exception)
    {
        $exception->update([
            'active' => !$exception->active
        ]);

        return back()->with('success', 'Exception status updated');
    }

    private function validateOverlap(Request $request, $ignoreId = null): void
    {
        $query = LoginTimeException::where('user_id', $request->user_id)
            ->where('active', true);

        if ($ignoreId) {
            $query->where('exception_id', '!=', $ignoreId);
        }

        $exists = $query->where(function ($q) use ($request) {
            $q->whereBetween('allowed_from', [$request->allowed_from, $request->allowed_to])
                ->orWhereBetween('allowed_to', [$request->allowed_from, $request->allowed_to])
                ->orWhere(function ($q2) use ($request) {
                    $q2->where('allowed_from', '<=', $request->allowed_from)
                        ->where('allowed_to', '>=', $request->allowed_to);
                });
        })->exists();

        if ($exists) {
            abort(422, 'Overlapping exception exists for this user');
        }
    }
}
