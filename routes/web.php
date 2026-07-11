<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AtpController;
use App\Http\Controllers\CpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalHarianController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ModulAjarController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringKelengkapanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProsemController;
use App\Http\Controllers\ProtaController;
use App\Http\Controllers\RuleAdministrasiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::resource('/kelas', KelasController::class);
    Route::resource('/pengguna', PenggunaController::class);
    Route::resource('/akun', AkunController::class);
    Route::resource('/siswa', SiswaController::class);
    Route::resource('/mapel', MapelController::class);
    Route::resource('/periode', PeriodeController::class);
    Route::get('/administrasi', [AdministrasiController::class, 'index'])->name('administrasi.index');
    Route::get('/administrasi/pdf',[AdministrasiController::class,'downloadPdf'])->name('administrasi.pdf');

    Route::resource('/cp', CpController::class);
    Route::get('/monitoring/cp', [MonitoringController::class, 'index'])->name('monitoring.cp');
    Route::put('/monitoring/cp/{id}/approve', [MonitoringController::class, 'approve'])->name('monitoring.cp.approve');
    Route::put('/monitoring/cp/{id}/revisi', [MonitoringController::class, 'revisi'])->name('monitoring.cp.revisi');
    Route::get('/monitoring/cp/{id}', [MonitoringController::class, 'show'])->name('monitoring.cp.show');
    Route::get('/cp/{id}/pdf', [CpController::class, 'downloadPdf'])->name('cp.pdf');

    Route::resource('/prota', ProtaController::class);
    Route::get('/prota/atp-detail/{idAdministrasi}', [ProtaController::class, 'getAtpDetail'])->name('prota.atp-detail');
    Route::get('/monitoring/prota', [MonitoringController::class, 'prota'])->name('monitoring.prota');
    Route::get('/monitoring/prota/{id}', [MonitoringController::class, 'showProta'])->name('monitoring.prota.show');
    Route::put('/monitoring/prota/{id}/approve', [MonitoringController::class, 'verifikasi'])->name('monitoring.prota.verifikasi');
    Route::put('/monitoring/prota/{id}/revisi', [MonitoringController::class, 'revisiProta'])->name('monitoring.prota.revisi');
    Route::get('/prota/get-atp-detail/{idAdministrasi}',[ProtaController::class, 'getAtpDetail'])->name('prota.get-atp-detail');
    Route::get('/prota/pdf/{id}', [ProtaController::class, 'downloadPdf'])->name('prota.pdf');

    Route::resource('/prosem',ProsemController::class);
    Route::get('/prosem/prota-detail/{id}',[ProsemController::class, 'getProtaDetail'])->name('prosem.prota-detail');
    Route::get('/monitoring/prosem', [MonitoringController::class, 'prosem'])->name('monitoring.prosem');
    Route::get('/monitoring/prosem/{id}', [MonitoringController::class, 'showProsem'])->name('monitoring.prosem.show');
    Route::put('/monitoring/prosem/{id}/approve', [MonitoringController::class, 'verifikasiProsem'])->name('monitoring.prosem.verifikasi');
    Route::put('/monitoring/prosem/{id}/revisi', [MonitoringController::class, 'revisiProsem'])->name('monitoring.prosem.revisi');
    Route::get('/prosem/pdf/{id}', [ProsemController::class, 'downloadPdf'])->name('prosem.pdf');

    Route::resource('/modul-ajar',ModulAjarController::class);
    Route::get('/modul-ajar/cp-detail/{id}',[ModulAjarController::class, 'getCpDetail']);
    Route::get('/modul-ajar/tp/{cp}/{semester}',[ModulAjarController::class, 'getTujuanPembelajaran']);
    Route::post('/ckeditor/upload',[ModulAjarController::class, 'uploadImage'])->name('ckeditor.upload');
    Route::get('/monitoring/modul-ajar', [MonitoringController::class, 'modulAjar'])->name('monitoring.modul-ajar');
    Route::get('/monitoring/modul-ajar/{id}', [MonitoringController::class, 'showModulAjar'])->name('monitoring.modul-ajar.show');
    Route::put('/monitoring/modul-ajar/{id}/approve', [MonitoringController::class, 'approveModulAjar'])->name('monitoring.modul-ajar.verifikasi');
    Route::put('/monitoring/modul-ajar/{id}/revisi', [MonitoringController::class, 'revisiModulAjar'])->name('monitoring.modul-ajar.revisi');
    Route::get('/modul-ajar/{id}/pdf',[ModulAjarController::class, 'downloadPdf'])->name('modul-ajar.pdf');

    Route::resource('/jurnal-harian', JurnalHarianController::class);
    Route::get('/get-cp/{id_administrasi}', [JurnalHarianController::class, 'getCp']);
    Route::get('/get-atp/{id_cp_detail}', [JurnalHarianController::class, 'getAtp']);
    Route::get('/jurnal-harian/pdf', [JurnalHarianController::class, 'pdf'])->name('jurnal-harian.pdf');

    Route::get('/rule-administrasi',[RuleAdministrasiController::class, 'index'])->name('rule-administrasi.index');
    Route::post('/rule-administrasi/update',[RuleAdministrasiController::class, 'update'])->name('rule-administrasi.update');

    Route::get('/monitoring-kelengkapan',[MonitoringKelengkapanController::class, 'index'])->name('monitoring.kelengkapan');
    Route::get('/monitoring-kelengkapan/pdf',[MonitoringKelengkapanController::class, 'downloadPdf'])->name('monitoring-kelengkapan.pdf');
    
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
require __DIR__ . '/auth.php';
