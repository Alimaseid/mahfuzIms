<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function expired()
    {
        return  view('expired');
    }
    public function index()
    {
        $today = Carbon::today();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // ================== DAILY ==================
        $dailyCash = DB::table('sales_orders')
            ->whereDate('created_at', $today)
            ->where('sales_type', 'Cash Sales')
            ->sum('grand_total');

        $dailyCredit = DB::table('sales_orders')
            ->whereDate('created_at', $today)
            ->where('sales_type', 'Credit Sales')
            ->sum('grand_total');

        $dailyCashVat = DB::table('sales_orders')
            ->whereDate('created_at', $today)
            ->where('sales_type', 'Cash Sales')
            ->sum('vat');

        $dailyCreditVat = DB::table('sales_orders')
            ->whereDate('created_at', $today)
            ->where('sales_type', 'Credit Sales')
            ->sum('vat');

        $dailyVat = $dailyCashVat + $dailyCreditVat;
        $dailyWithoutVat = ($dailyCash + $dailyCredit) - $dailyVat;

        // ================== MONTHLY ==================
        $monthlyCash = DB::table('sales_orders')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Cash Sales')
            ->sum('grand_total');

        $monthlyCredit = DB::table('sales_orders')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Credit Sales')
            ->sum('grand_total');

        $monthlyCashVat = DB::table('sales_orders')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Cash Sales')
            ->sum('vat');

        $monthlyCreditVat = DB::table('sales_orders')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Credit Sales')
            ->sum('vat');

        $monthlyVat = $monthlyCashVat + $monthlyCreditVat;
        $monthlyWithoutVat = ($monthlyCash + $monthlyCredit) - $monthlyVat;

        // ================== YEARLY ==================
        $yearlyCash = DB::table('sales_orders')
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Cash Sales')
            ->sum('grand_total');

        $yearlyCredit = DB::table('sales_orders')
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Credit Sales')
            ->sum('grand_total');

        $yearlyCashVat = DB::table('sales_orders')
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Cash Sales')
            ->sum('vat');

        $yearlyCreditVat = DB::table('sales_orders')
            ->whereYear('created_at', $year)
            ->where('sales_type', 'Credit Sales')
            ->sum('vat');

        $yearlyVat = $yearlyCashVat + $yearlyCreditVat;
        $yearlyWithoutVat = ($yearlyCash + $yearlyCredit) - $yearlyVat;

        // ================== CHART ==================
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weeklySales = DB::table('sales_orders')
            ->selectRaw('DAYOFWEEK(created_at) as day, SUM(grand_total - vat) as total_without_vat')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('day')
            ->pluck('total_without_vat', 'day');

        // Map database results to fixed Mon–Sun array
        $daysOfWeek = [
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
            1 => 'Sunday',
        ];

        $weeklySalesData = [];
        foreach ($daysOfWeek as $dayNum => $dayName) {
            $weeklySalesData[$dayName] = $weeklySales[$dayNum] ?? 0;
        }


        return view('pages.index', compact(
            // Daily
            'dailyCash',
            'dailyCredit',
            'dailyWithoutVat',
            'dailyCashVat',
            'dailyCreditVat',
            // Monthly
            'monthlyCash',
            'monthlyCredit',
            'monthlyWithoutVat',
            'monthlyCashVat',
            'monthlyCreditVat',
            // Yearly
            'yearlyCash',
            'yearlyCredit',
            'yearlyWithoutVat',
            'yearlyCashVat',
            'yearlyCreditVat',
            // Chart
            'weeklySalesData'
        ));
    }
}
