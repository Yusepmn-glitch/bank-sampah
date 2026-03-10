<?php

use App\Http\Controllers\ProfileController;
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

use App\Http\Controllers\SetoranController;
use App\Http\Controllers\AdminController;

Route::get('/login-vanilla', function () {
    return view('auth-vanilla.login');
})->name('login-vanilla');

Route::get('/register-vanilla', function () {
    return view('auth-vanilla.register');
})->name('register-vanilla');

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/admin-panel', function () {
    return view('admin-panel');
})->name('admin.panel');

Route::get('/cek-status', function () {
    return view('cek-status');
})->name('cek-status');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::put('/admin/setoran/{id}', [AdminController::class, 'updateStatus'])->name('admin.update-status');
    Route::delete('/admin/setoran/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
