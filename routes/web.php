<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Models\Pesanan;
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

Route::get('/', [PagesController::class, 'dashboard'])->name('index')->middleware('auth');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.action');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->name('register.action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('/users', UserController::class)->except('show');
    Route::resource('/jenis-produk', JenisProdukController::class)->except('show');
    Route::resource('/produk', ProdukController::class)->except('show');
});

Route::middleware(['auth', 'role:admin,staff,pelanggan'])->group(function () {
    Route::get('/profile', [UserController::class, 'myProfile'])->name('profile');
    Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/detail/{id}', [UserController::class, 'updateProfileDetail'])->name('profile.detail.update');

    Route::resource('/pesanan', PesananController::class)->only(['index', 'store', 'update']);
    Route::put('/pesanan/{pesanan}/{status}', [PesananController::class, 'updateStatus'])->name('pesanan.update.status');
});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/produk/list', [ProdukController::class, 'index'])->name('produk.list');
});
