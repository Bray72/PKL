<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpdDashboardController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\RemediasiController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');


    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

Route::middleware('auth')->get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])
    ->name('dokumen.download');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:4'])->group(function () {

    Route::get('/opd/dashboard', [OpdDashboardController::class, 'index'])
        ->name('opd.dashboard');
    
    Route::get('/opd/remediasi', [RemediasiController::class, 'index'])
        ->name('opd.remediasi');

    Route::put('/opd/remediasi/{temuan}', [RemediasiController::class, 'update'])
        ->name('opd.remediasi.update');
});

Route::middleware(['auth', 'role:1,2,3'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Pengajuan ITSA
    Route::get('/admin/pengajuan', [PengajuanController::class, 'index'])
        ->name('admin.pengajuan.index');

    Route::post('/admin/pengajuan', [PengajuanController::class, 'store'])
        ->name('admin.pengajuan.store');

    Route::delete('/admin/pengajuan/{ajuan}', [PengajuanController::class, 'destroy'])
        ->name('admin.pengajuan.destroy');

    Route::get('/admin/pengajuan/{ajuan}/edit', [PengajuanController::class, 'edit'])
    ->name('admin.pengajuan.edit');

    Route::put('/admin/pengajuan/{ajuan}', [PengajuanController::class, 'update'])
    ->name('admin.pengajuan.update');

    Route::get('/admin/temuan', [TemuanController::class, 'index'])
        ->name('admin.temuan.index');

    Route::post('/admin/temuan', [TemuanController::class, 'store'])
    ->name('admin.temuan.store');

    Route::get('/admin/temuan/{temuan}/edit', [TemuanController::class, 'edit'])
        ->name('admin.temuan.edit');

    Route::put('/admin/temuan/{temuan}', [TemuanController::class, 'update'])
        ->name('admin.temuan.update');

    Route::delete('/admin/temuan/{temuan}', [TemuanController::class, 'destroy'])
        ->name('admin.temuan.destroy');

    Route::get('/admin/dokumen',[DokumenController::class, 'index']
    )->name('dokumen.index');

    Route::post('/admin/dokumen',[DokumenController::class, 'store']
    )->name('dokumen.store');

    Route::delete('/admin/dokumen/{id}',[DokumenController::class, 'destroy']
    )->name('dokumen.destroy');
});

// Khusus Superadmin (role: 1)
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
