<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\LoginTimeService;
use App\Services\LoginAudit;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1️⃣ Authenticate credentials
        $request->authenticate();

        $user = Auth::user();

        // Make sure we use the correct user ID column
        $userId = $user->id ?? null;

        // 2️⃣ LOGIN TIME CHECK
        $result = app(LoginTimeService::class)->isAllowed($user);

        if (!$result['allowed']) {
            // Log blocked login
            LoginAudit::log($userId, 'blocked', $result['reason'] ?? 'policy');

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => $result['message']
            ]);
        }

        // 3️⃣ Successful login
        LoginAudit::log($userId, 'allowed', $result['reason'] ?? 'policy');

        $request->session()->regenerate();

        activity()
            ->causedBy($user)
            ->withProperties([
                'ip' => $request->ip(),
                'agent' => $request->userAgent(),
            ])
            ->log('User logged in');

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request): RedirectResponse
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => $request->ip(),
                'agent' => $request->userAgent()
            ])
            ->log('User logged out');

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
