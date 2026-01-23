<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginTimeException extends Model
{
    protected $primaryKey = 'exception_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'allowed_from',
        'allowed_to',
        'reason',
        'active',
        'created_by'
    ];

    protected $casts = [
        'allowed_from' => 'datetime',
        'allowed_to'   => 'datetime',
        'active'       => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
