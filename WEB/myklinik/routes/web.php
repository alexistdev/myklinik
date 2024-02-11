<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard,
    KategoriController as AdminKategori,
    GolonganController as AdminGolongan,
    ObatController as AdminObat};



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => 'admin'], function () {
        Route::get('/staff/dashboard', [AdminDashboard::class, 'index'])->name('adm.dashboard');

        Route::get('/staff/kategori', [AdminKategori::class, 'index'])->name('adm.kategori');
        Route::post('/staff/kategori', [AdminKategori::class, 'store'])->name('adm.kategori.save');
        Route::patch('/staff/kategori', [AdminKategori::class, 'update'])->name('adm.kategori.update');
        Route::delete('/staff/kategori', [AdminKategori::class, 'destroy'])->name('adm.kategori.delete');

        Route::get('/staff/golongan', [AdminGolongan::class, 'index'])->name('adm.golongan');
        Route::post('/staff/golongan', [AdminGolongan::class, 'store'])->name('adm.golongan.save');
        Route::patch('/staff/golongan', [AdminGolongan::class, 'update'])->name('adm.golongan.update');
        Route::delete('/staff/golongan', [AdminGolongan::class, 'destroy'])->name('adm.golongan.delete');

        Route::get('/staff/obat', [AdminObat::class, 'index'])->name('adm.obat');
        Route::get('/staff/obat/add', [AdminObat::class, 'create'])->name('adm.obat.add');
    });
});

require __DIR__.'/auth.php';
