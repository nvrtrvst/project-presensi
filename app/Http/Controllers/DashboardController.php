<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Carbon::setLocale('id');

class DashboardController extends Controller
{
    public function index() {

        $dateNow =  Carbon::now();
        $todayAttendance = DB::table('attendances')->where('nik', Auth::user()->nik)->where('attendance_date', date('Y-m-d'))->first();
        $historyMonth = DB::table('attendances')->whereRaw("MONTH(attendance_date) = MONTH(CURRENT_DATE())")->where('nik', Auth::user()->nik)->get();
        $month = \Carbon\Carbon::parse($dateNow)->translatedFormat('F');
        $year = \Carbon\Carbon::parse($dateNow)->translatedFormat('Y');


        $leaderboard = DB::table('attendances')
        ->join('employees', 'employees.nik', '=', 'attendances.nik')
        ->where('attendance_date', date('Y-m-d'))
        ->orderBy('check_in_time', 'asc')
        ->get();

        $recapMonth = DB::table('attendances')
        ->selectRaw('count(nik) as total_kehadiran, SUM(IF(check_in_time > "10:00", 1, 0)) AS total_terlambat')
        ->whereRaw("MONTH(attendance_date) = MONTH(CURRENT_DATE())")
        ->where('nik', Auth::user()->nik)->first();

        return view('dashboard.dashboard', compact('todayAttendance','historyMonth', 'month', 'year','recapMonth', 'leaderboard'));
    }
}
