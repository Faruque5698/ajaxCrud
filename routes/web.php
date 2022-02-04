<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/employee',[EmployeeController::class,'index']);
Route::post('employee',[EmployeeController::class,'store']);
Route::get("fetch-employee",[EmployeeController::class,'show']);
Route::get("edit-employee/{id}",[EmployeeController::class,'edit']);
Route::get("delete-employee/{id}",[EmployeeController::class,'delete']);
Route::post("update-employee",[EmployeeController::class,'update']);
