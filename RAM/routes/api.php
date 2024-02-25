<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TblUserController;
use App\Http\Controllers\Api\TblScheduleController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/appointments/approve/{reference_id}', [TblScheduleController::class, 'approveAppointment']);
    Route::post('/appointments/reschedule/{reference_id}', [TblScheduleController::class, 'rescheduleAppointment']);
    Route::post('/appointments/followup/{reference_id}', [TblScheduleController::class, 'followUpAppointment']);
    Route::post('/appointments/release/{reference_id}', [TblScheduleController::class, 'releaseAppointment']);

    Route::post('/admin/create', [TblUserController::class, 'createAdmin'])->middleware(['auth:sanctum', 'isSuperAdmin']);
    Route::post('/users/create', [TblUserController::class, 'createUser']);

});

Route::post('/schedules/create', [TblScheduleController::class, 'createSchedule']);

Route::post('/login', [AuthController::class, 'login']);
// Route::post('/login', [TblUserController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

Route::middleware(['auth:sanctum', 'isSuperAdmin'])->post('/admin/create', [TblUserController::class, 'createAdmin']);

// Route::post('/login', 'AuthController@login')->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [TblUserController::class, 'login'])->name('processLogin');

Route::post('/users/create', [TblUserController::class, 'createUser']);

Route::get('/schedules', [TblScheduleController::class, 'viewSchedules']);

// for my account
Route::middleware('auth:sanctum')->get('/user/details', [TblUserController::class, 'currentUserDetails']);

// for update password
Route::middleware('auth:sanctum')->post('/user/update-password', [TblUserController::class, 'updatePassword']);
// for disable admin
Route::post('/admins/disable/{user_id}', [TblUserController::class, 'disableAdmin'])->name('api.admins.disable');

Route::post('/appointments/update/{reference_id}', 'App\Http\Controllers\Api\TblScheduleController@updateStatus')->name('appointments.updateStatus');

// ANDROID
Route::post('/login', [TblUserController::class, 'loginAndroid'])->name('processLogin');

Route::get('/users/{user_id}/info', [TblUserController::class, 'showInfo_Android']);

Route::post('/schedules/create', [TblScheduleController::class, 'createScheduleAndroid']);
Route::get('/appointment/created',[TblScheduleController::class, 'getAppointmentsByCreatorId']);
// UPDATED 2/25
Route::post('/schedules/delete', [TblScheduleController::class, 'deleteScheduleAndroid']);




