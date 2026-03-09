<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\MahasiswaAktif;
use App\Http\Livewire\MahasiswaTidakAktif;
use App\Http\Livewire\SemuaMahasiswa;

Route::get('/', function () {
    return redirect('/auth');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD & MENU
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', Dashboard::class);
Route::get('/semua_mahasiswa', SemuaMahasiswa::class);
Route::get('/mahasiswa_aktif', MahasiswaAktif::class);
Route::get('/mahasiswa_tidak_aktif', MahasiswaTidakAktif::class);
Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {

    Route::get('/auth', 'index')->name('auth');
    Route::post('/proses_login', 'proses_login');

    Route::get('/registrasi', 'registrasi');
    Route::post('/proses_registrasi', 'proses_registrasi');

    Route::get('/lupa_password', 'lupaPassword');
    Route::post('/proses_lupa_password', 'proses_lupa_password');
});