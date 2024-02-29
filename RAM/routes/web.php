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


Route::get('/', function () {return redirect('/login');});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//KENTH
// update status in manage appointment
Route::post('/manage-appointments/update-status/{reference_id}', [TblScheduleController::class, 'updateStatus'])->name('appointments.updateStatus');
Route::get('/manage-appointments', [TblScheduleController::class, 'showAppointments'])->name('manage_appointments.index');
//KENTH

Route::get('/manage-admins', function () {return view('manage_admins.index');})->name('manage-admins')->middleware('auth', 'role:superadmin')->name('manage-admins');

// Display list of admins
Route::get('/manage-admins', [TblUserController::class, 'showAdmins'])->name('manage_admins.index');
// Create admins
Route::post('/create-admin', [TblUserController::class, 'createAdmin'])->name('admin.create');
// display create admin form
Route::get('/create-admin', [TblUserController::class, 'showCreateAdminForm'])->name('create-admin.show');
// Disable admins
Route::post('/admins/disable/{user_id}', [TblUserController::class, 'disableAdmin'])->name('admins.disable');
// Enable admins
Route::post('/admins/enable/{user_id}', [TblUserController::class, 'enableAdmin'])->name('admins.enable');
// display enable/disable admins
Route::get('admins/manage', [TblUserController::class, 'showdisableAdmin'])->name('admins_manage.show');
// my account view
Route::get('/my-account', function () {return view('my_account.index');})->name('my-account');

// show stats
Route::get('/superadmin/dashboard', [TblScheduleController::class, 'showStats'])->name('dashboard.stats');

// display dashboard according to role
Route::get('/admin/dashboard', [TblScheduleController::class, 'showDashboard'])->middleware('auth', 'role:admin')->name('admin');
Route::get('/superadmin/dashboard', [TblScheduleController::class, 'showDashboard'])->middleware('auth', 'role:superadmin')->name('superadmin');
Route::get('/user/info', [TblScheduleController::class, 'showDashboard'])->middleware('auth')->name('user');
// update user password
Route::post('/user/update-password', [TblUserController::class, 'updatePassword'])->name('user.update-password');

Route::get('superadmin/dashboard', [TblScheduleController::class, 'index'])->name('superadmin.dashboard');
Route::get('admin/dashboard', [TblScheduleController::class, 'index'])->name('admin.dashboard');

// Searchbar
// Route::get('superadmin/dashboard', [TblScheduleController::class, 'index'])->name('dashboard');

// Route::post('/appointments/reschedule/{reference_id}', [TblScheduleController::class, 'rescheduleAppointment'])->name('appointments.reschedule');
// Route::get('/schedules/reschedule/{reference_id}', [TblScheduleController::class, 'editReschedule'])->name('schedules.editReschedule');

// Route::get('/dashboard', [TblScheduleController::class, 'showDashboard'])->name('dashboard');
// Superadmin Dashboard
// Route::get('/superadmin/dashboard', function () {return view('superadmin');})->name('superadmin');
// Admin Dashboard
// Route::get('/admin/dashboard', function () {return view('admin');})->name('admin');
// User Info Page
// Route::get('/user/info', function () {return view('user');})->name('user');
