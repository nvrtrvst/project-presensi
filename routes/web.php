<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     if (Auth::guard('employee')->check()) {
//         return redirect()->route('dashboard');
//     }
//     return view('auth.login');
// })->name('login');

Route::middleware(['guest:employee'])->group(function () {
    Route::get('/', function () {
        return view('auth/login');
    })->name('login');

    Route::post('/loginprocess', [AuthController::class, 'loginProcess'])->name('loginprocess');
});


Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logoutprocess', [AuthController::class, 'logoutProcess'])->name('logoutprocess');

    //Presensi
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances/store', [AttendanceController::class, 'store'])->name('attendances.store');

    //editprofile
    Route::get('/editprofile', [AttendanceController::class, 'editProfile'])->name('attendances.editprofile');
    Route::post('/attendances/{nik}/updateprofile', [AttendanceController::class, 'updateProfile'])->name('attendances.updateprofile');
});

// Route::view('dashboard', 'dashboard')j
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

// require __DIR__.'/auth.php';
?>
