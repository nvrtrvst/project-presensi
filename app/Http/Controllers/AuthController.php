<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Echo_;

class AuthController extends Controller
{
    public function loginProcess(Request $request) {
        if(Auth::guard('employee')->attempt(['nik'=> $request->nik, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with('warning', 'NIK atau Password Salah');
        }
    }

    public function logoutProcess() {
        if(Auth::guard('employee')->check()){
            Auth::guard('employee')->logout();;
            return redirect('/');
        }
    }
}
