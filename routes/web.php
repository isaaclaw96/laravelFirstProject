<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DepartmentController;

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

Route::prefix('admin')->group(function(){
    Route::any('/', [AdminController::class, 'index']);
    Route::any('/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::any('/users',[UserController::class, 'index'])->name('user');
    Route::any('/jobs',[JobController::class, 'index'])->name('job');
    Route::any('/departments',[DepartmentController::class, 'index'])->name('department');


    Route::any('/edituser/{id}', [UserController::class,'edit'])->name('edituser');
    Route::any('/user/delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::any('/jobedit/{id}', [JobController::class,'edit'])->name('jobedit');
    Route::any('/job/delete/{id}', [JobController::class, 'delete'])->name('delete');
    Route::any('/deptedit/{id}', [DepartmentController::class,'edit'])->name('deptedit');
    Route::any('/deparment/delete/{id}', [DepartmentController::class, 'delete'])->name('delete');


});

Route::view('/fakelogin','fakelogin');
Route::view('/fakedashboard','fakedashboard');


