<?php

use Illuminate\Support\Facades\Route;
Route::get('/students', [App\Http\Controllers\StudentController::class, 'index']);
Route::post('/add-student', [App\Http\Controllers\StudentController::class, 'store']);
Route::get('/get-student', [App\Http\Controllers\StudentController::class, 'getstudent']);
Route::get('/edit-student/{id}', [App\Http\Controllers\StudentController::class, 'editstudent']);
Route::put('/update-student/{id}', [App\Http\Controllers\StudentController::class, 'update']);
Route::get('/delete/{id}', [App\Http\Controllers\StudentController::class, 'delete']);

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


