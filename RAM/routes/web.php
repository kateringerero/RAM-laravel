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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/users', [TblUserController::class, 'index']);
Route::post('/users', [TblUserController::class, 'store']);
Route::get('/schedules', [TblScheduleController::class, 'index']);
Route::post('/schedules', [TblScheduleController::class, 'store']);
// Route::get('/login', 'AuthController@showLoginForm')->name('login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');


