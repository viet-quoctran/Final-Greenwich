<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\AdminController;
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
Route::post('/guest', [GuestController::class, 'store'])->name('guest.store');


Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminController::class, 'loginProcess'])->name('admin.login.process');
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->middleware('is_admin')->name('admin.dashboard');
    Route::post('/admin/logout', [App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/guests/status/{guestId}', [App\Http\Controllers\Admin\AdminController::class, 'updateUserFromGuest'])->middleware('is_admin')->name('admin.guests.updateStatus');
});

















Route::get('hello',function(){
    return view('admin.index');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
