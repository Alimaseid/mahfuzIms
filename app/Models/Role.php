<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
         'role_name',
         'manage_user',
         'manage_item',
         'manage_vendor',
         'manage_purchase',
         'manage_customer',
         'manage_customer_history',
         'manage_sales',
         'manage_order',
         'manage_store_issue',
         'approval',
         'reports'
    ];
}
