<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoginTimePolicy;

class LoginTimePolicySeeder extends Seeder
{
    public function run(): void
    {
        LoginTimePolicy::firstOrCreate(
            ['active' => true],
            [
                'start_time' => '08:00',
                'end_time'   => '17:00',
                'timezone'   => 'Africa/Addis_Ababa',
                'created_by' => 1 // Super Admin ID
            ]
        );
    }
}
