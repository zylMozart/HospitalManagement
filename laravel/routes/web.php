<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AlarmController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::post('data',[DataController::class,'sign']);

Route::post('user/register',[UserController::class,'register']);
Route::post('user/login',[UserController::class,'login']);
Route::post('user/profile',[UserController::class,'profile']);
Route::post('user/report',[UserController::class,'report']);
Route::post('user/change',[UserController::class,'change']);
Route::post('user/add',[UserController::class,'add']);
Route::post('user/delete',[UserController::class,'delete']);
Route::post('user/log',[UserController::class,'log']);


Route::post('alarmstd/add',[AlarmController::class,'addstd']);
Route::post('alarmstd/change',[AlarmController::class,'changestd']);
Route::post('alarmstd/show',[AlarmController::class,'showstd']);
Route::post('copewarning',[AlarmController::class,'cope']);

Route::post('allusers',[UserController::class,'allusers']);
Route::post('diagnosis',[ReportController::class,'diagnosis']);

