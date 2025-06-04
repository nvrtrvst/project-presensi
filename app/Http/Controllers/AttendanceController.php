<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function create() {
        $check = DB::table('attendances')->where('nik', Auth::user()->nik)->where('attendance_date', date('Y-m-d'))->count();
            return view('attendances.create', compact('check'));
        }


    public function store(Request $request) {
        $nik = Auth::user()->nik;
        $attendance_date = date('Y-m-d');
        $check_in_time = date('H:i:s');
        $location = $request->location;
        $image = $request->image;
        $folderPath = "uploads/attendance/";
        $formatName = $nik."-".$attendance_date;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath.$fileName;

        $check = DB::table('attendances')->where('nik', Auth::user()->nik)->where('attendance_date', date('Y-m-d'))->count();
        if($check > 0) {
            //update data plg
            $check_out = [
                'check_out_time' => $check_in_time,
                'check_out_photo' => $fileName,
                'check_out_location' => $location
            ];
            $update = DB::table('attendances')->where('nik', Auth::user()->nik)->where('attendance_date', date('Y-m-d'))->update($check_out);
            if ($update) {
                echo "success|Terima Kasih, hati-hati di jalan!|out";
                Storage::disk('public')->put($file, $image_base64);
            } else {
                echo "erro|Presensi gagal, silahkan hubungi IT!|out";
            }
        }else {
            //insert data masuk
                $data = [
                    'nik' => $nik,
                    'attendance_date' => $attendance_date,
                    'check_in_time' => $check_in_time,
                    'check_in_photo' => $fileName,
                    'check_in_location' => $location
                ];
                $save = DB::table('attendances')->insert($data);
                if($save) {
                    echo "success|Terima Kasih, Selamat bekerja!|in";
                    Storage::disk('public')->put($file, $image_base64);
                }else {
                    echo "error|Presensi gagal, silahkan hubungi IT!|out";
                }
            }
        }

        //hitung jarak presensi
        function distance($lat1, $lon1, $lat2, $lon2) {
            $theta = $lon1 - $lon2;
            $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
            $miles = acos($miles);
            $miles = rad2deg($miles);
            $miles = $miles * 60 * 1.1515;
            $feet = $miles * 5280;
            $yards = $feet / 3;
            $kilometers = $miles * 1.609344;
            $meters = $kilometers * 1000;
            return compact('meters');
        }
    }

