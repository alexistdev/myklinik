<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard,
    KategoriController as AdminKategori,
    GolonganController as AdminGolongan,
    ObatController as AdminObat,
    PoliklinikController as AdminPoli,
    KaryawanController as AdminKaryawan,
    DokterController as AdminDokter};


Route::redirect('/', '/login');
//Route::get('/', function () {
//    return view('welcome');
//});

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
        Route::post('/staff/obat', [AdminObat::class, 'store'])->name('adm.obat.save');
        Route::patch('/staff/obat', [AdminObat::class, 'update'])->name('adm.obat.update');
        Route::delete('/staff/obat', [AdminObat::class, 'destroy'])->name('adm.obat.delete');
        Route::get('/staff/{id}/obat', [AdminObat::class, 'edit'])->name('adm.obat.edit');
        Route::get('/staff/obat/add', [AdminObat::class, 'create'])->name('adm.obat.add');

        Route::get('/staff/poliklinik', [AdminPoli::class, 'index'])->name('adm.poli');
        Route::post('/staff/poliklinik', [AdminPoli::class, 'store'])->name('adm.poli.save');
        Route::patch('/staff/poliklinik', [AdminPoli::class, 'update'])->name('adm.poli.update');
        Route::delete('/staff/poliklinik', [AdminPoli::class, 'destroy'])->name('adm.poli.delete');

        Route::get('/staff/karyawan', [AdminKaryawan::class, 'index'])->name('adm.karyawan');
        Route::get('/staff/karyawan/add', [AdminKaryawan::class, 'create'])->name('adm.karyawan.add');
        Route::get('/staff/{id}/karyawan', [AdminKaryawan::class, 'edit'])->name('adm.karyawan.edit');
        Route::post('/staff/karyawan', [AdminKaryawan::class, 'store'])->name('adm.karyawan.save');
        Route::patch('/staff/karyawan', [AdminKaryawan::class, 'update'])->name('adm.karyawan.update');
        Route::delete('/staff/karyawan', [AdminKaryawan::class, 'destroy'])->name('adm.karyawan.delete');

        Route::get('/staff/dokter', [AdminDokter::class, 'index'])->name('adm.dokter');
        Route::post('/staff/dokter', [AdminDokter::class, 'store'])->name('adm.dokter.save');
        Route::get('/staff/dokter/add', [AdminDokter::class, 'create'])->name('adm.dokter.add');


    });
});

require __DIR__.'/auth.php';
