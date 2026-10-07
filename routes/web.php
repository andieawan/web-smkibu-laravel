<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ---------- Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/berita', [HalamanController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HalamanController::class, 'beritaShow'])->name('berita.show');
Route::get('/galeri', [HalamanController::class, 'galeri'])->name('galeri');

// Halaman yang belum dibuat (placeholder) agar menu tidak error.
foreach (['profil', 'akademik', 'kesiswaan', 'ppdb'] as $halaman) {
    Route::view('/' . $halaman, 'placeholder', ['judul' => ucfirst($halaman)])->name($halaman);
}

// ---------- Login / logout ----------
Route::get('/login', [Admin\AuthController::class, 'form'])->name('login');
Route::post('/login', [Admin\AuthController::class, 'masuk'])->middleware('throttle:6,1')->name('login.proses');
Route::post('/logout', [Admin\AuthController::class, 'keluar'])->name('logout');

// ---------- Panel admin ----------
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('berita', Admin\BeritaController::class)->except('show');
    Route::resource('pengumuman', Admin\PengumumanController::class)->except('show');
    Route::resource('agenda', Admin\AgendaController::class)->except('show');
    Route::resource('galeri', Admin\GaleriController::class)->except('show');
    Route::resource('program', Admin\ProgramKeahlianController::class)->except('show');

    Route::get('pengaturan', [Admin\PengaturanController::class, 'edit'])->name('pengaturan');
    Route::put('pengaturan', [Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
});
