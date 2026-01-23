<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginTimePolicy extends Model
{
    use HasFactory;
    protected $primaryKey = 'policy_id';
    public $timestamps = false;

    protected $fillable = [
        'start_time',
        'end_time',
        'timezone',
        'active',
        'created_by'
    ];
}
