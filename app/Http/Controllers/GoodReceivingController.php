<?php

namespace App\Http\Controllers;

use App\Imports\GoodReceivingImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class GoodReceivingController extends Controller
{
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);

    Excel::import(new GoodReceivingImport, $request->file('file'));

    return back()->with('success', 'Goods imported successfully!');
}
}
