<?php

namespace App\Services;

use App\Models\User;
use App\Models\LoginTimePolicy;
use App\Models\LoginTimeException;
use Carbon\Carbon;

class LoginTimeService
{
    public function isAllowed(User $user): array
    {
        // ✅ SUPER ADMIN BYPASS
        if ($user->hasRole('Super Admin')) {
            return ['allowed' => true];
        }

        // ✅ Use system timezone
        $timezone = LoginTimePolicy::where('active', true)
            ->value('timezone') ?? config('app.timezone');

        $now = Carbon::now($timezone);

        // ✅ CHECK USER EXCEPTION
        $exception = LoginTimeException::where('user_id', $user->id)
            ->where('active', true)
            ->where('allowed_from', '<=', $now)
            ->where('allowed_to', '>=', $now)
            ->first();

        if ($exception) {
            return [
                'allowed' => true,
                'reason' => 'exception'
            ];
        }

        // ✅ CHECK SYSTEM POLICY
        $policy = LoginTimePolicy::where('active', true)->first();

        if (!$policy) {
            return ['allowed' => true];
        }

        $start = Carbon::createFromTimeString($policy->start_time, $timezone);
        $end   = Carbon::createFromTimeString($policy->end_time, $timezone);

        if ($now->between($start, $end)) {
            return ['allowed' => true];
        }

        return [
            'allowed' => false,
            'reason'  => 'policy',
            'message' => "Login allowed only between {$policy->start_time} and {$policy->end_time}. Please contact admin."
        ];
    }
}
