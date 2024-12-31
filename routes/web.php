<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailProfileController;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeminjamanAdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjagaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\BeamsAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\NotifikasiAdminController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PanduanController;

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

Route::get('/beams/auth', [BeamsAuthController::class, 'auth'])->middleware('auth');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', fn() => view('home'));

Route::get('/sarana-prasarana', [SaranaController::class, 'daftarSarana'])->name('user.sarana');
Route::get('/sarana-prasarana/{sarana}', [SaranaController::class, 'userShow'])->name('user.sarana.show');
Route::get('/sarana-prasarana/ruangan/{ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');
Route::get('/panduan/status', [PanduanController::class, 'status'])->name('panduan.status');
Route::get('/panduan/syarat', [PanduanController::class, 'syarat'])->name('panduan.syarat');
Route::get('/panduan/cara', [PanduanController::class, 'cara'])->name('panduan.cara');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [DetailProfileController::class, 'index'])->name('profile.index');
    Route::get('/change-password', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'update'])->name('password.change.update');
});

Route::group(['middleware' => ['checkRole:superadmin,pimpinan', 'verified'], 'prefix' => 'admin'], function () {
    Route::post('/peminjaman/store', [PeminjamanAdminController::class, 'store'])->name('peminjaman.admin.store');
    Route::put('/peminjaman/{id}/batal', [PeminjamanAdminController::class, 'batalkanPeminjaman'])->name('peminjaman.admin.batal');
});
Route::group(['middleware' => ['checkRole:superadmin,admin,pimpinan', 'verified'], 'prefix' => 'admin'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('peminjaman', PeminjamanAdminController::class);
    Route::get('/overview', [PeminjamanAdminController::class, 'overview'])->name('admin.overview');
    Route::get('/peminjaman-masuk', [PeminjamanAdminController::class, 'PeminjamanMasuk'])->name('peminjaman.admin.masuk');
    Route::get('/peminjaman-proses', [PeminjamanAdminController::class, 'PeminjamanDiproses'])->name('peminjaman.admin.diproses');
    Route::get('/peminjaman-setuju', [PeminjamanAdminController::class, 'PeminjamanDisetujui'])->name('peminjaman.admin.disetujui');
    Route::get('/peminjaman-tolak', [PeminjamanAdminController::class, 'PeminjamanDitolak'])->name('peminjaman.admin.ditolak');
    Route::get('/peminjaman-batal', [PeminjamanAdminController::class, 'PeminjamanDibatalkan'])->name('peminjaman.admin.dibatalkan');
    Route::get('/pengajuan-batal', [PeminjamanAdminController::class, 'PeminjamanDiajukanBatal'])->name('peminjaman.admin.diajukanbatal');
    Route::get('/peminjaman-selesai', [PeminjamanAdminController::class, 'PeminjamanSelesai'])->name('peminjaman.admin.selesai');
    Route::put('/peminjaman/{id}/update-status', [PeminjamanAdminController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::post('/peminjaman/{id}/evaluasi', [PeminjamanAdminController::class, 'evaluasi'])->name('peminjaman.evaluasi');

    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::patch('/kategori/{kategori}/activate', [KategoriController::class, 'activate'])->name('kategori.activate');

    Route::resource('sarana', SaranaController::class);
    Route::post('/sarana', [SaranaController::class, 'store'])->name('sarana.store');
    Route::get('/sarana', [SaranaController::class, 'index'])->name('sarana.index');
    Route::put('/sarana/{sarana}', [SaranaController::class, 'update'])->name('sarana.update');
    Route::delete('/sarana/{sarana}', [SaranaController::class, 'destroy'])->name('sarana.destroy');
    Route::patch('/sarana/{sarana}/activate', [SaranaController::class, 'activate'])->name('sarana.activate');
    Route::get('/sarana/{idSarana}/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/sarana/{idSarana}/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/sarana/{idSarana}/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/sarana/{idSarana}/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    Route::delete('/sarana/{idSarana}/ruangan/delete-image/{id}', [RuanganController::class, 'deleteImage'])->name('ruangan.delete-image');

    Route::resource('jadwal', JadwalController::class)->except(['show']); 
    Route::patch('/jadwal/{jadwal}/activate', [JadwalController::class, 'activate'])->name('jadwal.activate');

    Route::resource('penjaga', PenjagaController::class);
    Route::get('/penjaga', [PenjagaController::class, 'index'])->name('penjaga.index');

    Route::get('/profile', fn() => view('admin.profile'))->name('admin.profile');

    Route::get('/notifikasi', [NotifikasiAdminController::class, 'index'])->name('notifikasi.admin.index');
    Route::post('/notifikasi/{notifikasi}/mark-as-read', [NotifikasiAdminController::class, 'markAsRead'])->name('notifikasi.admin.mark-as-read');
});

Route::group(['middleware' => ['checkRole:user', 'verified']], function () {
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::resource('riwayat', RiwayatController::class);
    Route::post('/riwayat/{id}/upload-bukti', [RiwayatController::class, 'uploadBuktiPembayaran'])->name('riwayat.upload-bukti');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{notifikasi}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.mark-as-read');

    Route::post('/peminjaman/{peminjaman}/cancel', [PeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
});

Route::group(['middleware' => ['checkRole:superadmin,pimpinan', 'verified']], function () {
    Route::resource('pengguna', PenggunaController::class);
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
});

Route::group(['middleware' => ['checkRole:pimpinan', 'verified']], function () {
    Route::resource('keuangan', PenggunaController::class);
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
});

Route::get('/pengumuman', [PengumumanController::class, 'indexUser'])->name('pengumuman.user');

require __DIR__ . '/auth.php';