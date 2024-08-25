<?php

namespace App\Http\Controllers\Back;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('back.dashboard.index', [
            'totalCourse' => Course::count(),
            'totalMentor' => User::whereRole('mentor')->count(),
            'totalMentee' => User::whereRole('mentee')->count(),
            'paymentPending' => Payment::whereStatus('pending')->count()
        ]);
    }
}
