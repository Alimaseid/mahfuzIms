<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    //

    public function index()
    {
        // Fetch latest activities with related user
        $activities = Activity::with('causer')->latest()->paginate(20);

        return view('pages.log_activities.log', compact('activities'));
    }
}
