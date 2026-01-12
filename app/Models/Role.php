<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'supper_admin',

        'manage_user',
        'manage_edit_user',
        'manage_delete_user',

        'manage_location',
        'manage_edit_location',
        'manage_delete_location',

        'manage_item',
        'manage_edit_item',
        'manage_delete_item',
        'set_item_price',

        'manage_item_unit',
        'manage_edit_itemUnit',
        'manage_delete_itemUnit',

        'manage_category',
        'manage_edit_category',
        'manage_delete_category',

        'manage_shelf',
        'manage_edit_shelf',
        'manage_delete_shelf',

        'manage_customer',
        'manage_edit_customer',
        'manage_delete_customer',
        'manage_customer_history',
        'manage_dailycustomerReport',

        'manage_good_receiving',
        'manage_edit_goodreceiving',
        'manage_delete_goodreceiving',

        'manage_purchase_plan',
        'manage_delete_purchasePlan',

        'manage_sales',
        'manage_edit_sales',
        'manage_delete_sales',
        'manage_dailysalesReport',
        'manage_shopStock_reports',
        'manage_shopTRansferReports',

        'manage_disposal',
        'manage_edit_disposal',
        'manage_delete_disposal',

        'manage_item_transfer',
        'manage_itemTransfer_delete',

        'manage_stock_reports',
        'manage_storeTRansferReports',

        'manage_activity_log',
        'approval',
        'manage_notification',

        'manage_image',
        'manage_partNumber',
        'manage_partNumber2',
        'manage_price',

    ];
}
