<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
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

Route::get('/', [PageController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('home', [PageController::class, 'home'])->middleware('auth');

Route::get('records', [PageController::class, 'records'])->middleware('auth');
Route::post('loadEmployees', [EmployeeController::class, 'loadEmployees'])->name('loadEmployees');
Route::post('saveEmployee', [EmployeeController::class, 'saveEmployee']);
Route::post('deleteEmployee', [EmployeeController::class, 'deleteEmployee']);
Route::post('editEmployeeForm', [EmployeeController::class, 'editEmployeeForm']);
Route::post('updateEmployee', [EmployeeController::class, 'updateEmployee']);
