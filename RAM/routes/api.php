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

Route::middleware(['auth:sanctum', 'isSuperAdmin'])->post('/admin/create', [TblUserController::class, 'createAdmin']);

// Route::post('/login', 'AuthController@login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [TblUserController::class, 'login'])->name('processLogin');

Route::post('/users/create', [TblUserController::class, 'createUser']);




