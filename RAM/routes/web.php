<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TblUserController;
use App\Http\Controllers\Api\TblScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('/login');
    });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//KENTH - di ko maalala kung may binago ba ako here
Route::get('/manage-appointments', function () {
    return view('manage_appointments.index');
    })->name('manage-appointments');
//KENTH

Route::get('/manage-admins', function () {
    return view('manage_admins.index');
    })->name('manage-admins')->middleware('auth', 'role:superadmin')->name('manage-admins');

// Display list of admins
Route::get('/manage-admins', [TblUserController::class, 'showAdmins'])->name('manage_admins.index');
// Create admins
Route::post('/create-admin', [TblUserController::class, 'createAdmin'])->name('admin.create');
// Disable admins
Route::post('/admins/disable/{user_id}', [TblUserController::class, 'disableAdmin'])->name('admins.disable');

Route::get('/my-account', function () {
    return view('my_account.index');
    })->name('my-account');

// Superadmin Dashboard
Route::get('/superadmin/dashboard', function () {
    return view('superadmin');
})->name('superadmin');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin');
})->name('admin');

// User Info Page
Route::get('/user/info', function () {
    return view('user');
})->name('user');

Route::get('/admin/dashboard', [TblScheduleController::class, 'showDashboard'])->middleware('auth', 'role:admin')->name('admin');
Route::get('/superadmin/dashboard', [TblScheduleController::class, 'showDashboard'])->middleware('auth', 'role:superadmin')->name('superadmin');
Route::get('/user/info', [TblScheduleController::class, 'showDashboard'])->middleware('auth')->name('user');


// Route::get('/dashboard', [TblScheduleController::class, 'showDashboard'])->name('dashboard');

Route::post('/manage-appointments', [TblScheduleController::class, 'updateStatus'])->name('schedules.updateStatus');

Route::post('/appointments/update/{reference_id}', [App\Http\Controllers\Api\TblScheduleController::class, 'updateStatus'])->name('appointments.updateStatus');

// Analytics
// Route::get('/dashboard', [TblScheduleController::class, 'monthlyScheduleAnalytics'])->name('dashboard.index');
Route::get('/dashboard', [TblScheduleController::class, 'monthlyScheduleAnalytics'])->name('dashboard.index');


// update password
Route::post('/user/update-password', [TblUserController::class, 'updatePassword'])->name('user.update-password');

//KENTH
Route::get('/manage_appointments', [TblScheduleController::class, 'showAppointments'])->name('manage_appointments.index');
//KENTH

// Route::post('/appointments/reschedule/{reference_id}', [TblScheduleController::class, 'rescheduleAppointment'])->name('appointments.reschedule');
// Route::get('/schedules/reschedule/{reference_id}', [TblScheduleController::class, 'editReschedule'])->name('schedules.editReschedule');






