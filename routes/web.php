<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran');
Route::get('/konfirmasi-pembayaran', [PaymentController::class, 'confirmation'])->name('pembayaran.confirmation');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola Menu
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/terlaris', [AdminMenuController::class, 'terlaris'])->name('menu.terlaris');
    Route::get('/menu/tambah', [AdminMenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [AdminMenuController::class, 'destroy'])->name('menu.destroy');

    // Pesanan (Dine In & Take Away)
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/dine-in', [AdminPesananController::class, 'dineIn'])->name('pesanan.dine_in');
    Route::get('/pesanan/take-away', [AdminPesananController::class, 'takeAway'])->name('pesanan.take_away');
    Route::get('/pesanan/baru', [AdminPesananController::class, 'create'])->name('pesanan.create');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');

    // Kelola Banner & Gambar Landing Page
    Route::get('/banner', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banner.index');
    Route::post('/banner/update', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('banner.update');
    Route::post('/banner/reset', [App\Http\Controllers\Admin\BannerController::class, 'reset'])->name('banner.reset');

    // Pengaturan Akun
    Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun');
    Route::put('/akun', [AdminAkunController::class, 'update'])->name('akun.update');
});
