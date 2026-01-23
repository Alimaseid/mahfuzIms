<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LoginAudit
{
    public static function log(?int $userId, string $status, string $reason): void
    {
        DB::table('login_audit_logs')->insert([
            'user_id'      => $userId, // can be null
            'attempted_at' => now(),
            'status'       => $status,
            'reason'       => $reason
        ]);
    }
}
