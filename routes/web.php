<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[\App\Http\Controllers\User\LoginController::class, 'index'])->name('index.login');
Route::get('checkout/{name}/{prce}',function($name,$price){
    return view('checkout',compact('name','price'));
})->name('checkout')->middleware('auth');


Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callbackGoogle']);


Route::post('/guest', [GuestController::class, 'store'])->name('guest.store');
