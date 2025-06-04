<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {

        $todayAttendance = DB::table('attendances')->where('nik', Auth::user()->nik)->where('attendance_date', date('Y-m-d'))->first();
        $historyMonth = DB::table('attendances')->whereRaw("MONTH(attendance_date) = MONTH(CURRENT_DATE())")->where('nik', Auth::user()->nik)->get();


        return view('dashboard.dashboard', compact('todayAttendance','historyMonth'));
    }
}
