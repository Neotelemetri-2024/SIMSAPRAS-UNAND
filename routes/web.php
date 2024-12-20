<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeminjamanAdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjagaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/home', function () {
    return view('home');
});
 Route::get('/sarana-prasarana', [SaranaController::class, 'daftarSarana'])->name('user.sarana');
 Route::get('/sarana-prasarana/{sarana}', [SaranaController::class, 'userShow'])->name('user.sarana.show');
Route::get('sarana-prasarana/ruangan/{ruangan}', [RuanganController::class, 'show'])
    ->name('ruangan.show');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [DetailProfileController::class, 'index'])->name('profile.index');
});

Route::group(['middleware' => ['checkRole:superadmin,admin,pimpinan'], 'prefix' => 'admin'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('peminjaman', PeminjamanAdminController::class);
    Route::get('/peminjaman-masuk', [PeminjamanAdminController::class, 'PeminjamanMasuk'])->name('peminjaman.admin.masuk');
    Route::get('/peminjaman-proses', [PeminjamanAdminController::class, 'PeminjamanDiproses'])->name('peminjaman.admin.diproses');
    Route::get('/peminjaman-setuju', [PeminjamanAdminController::class, 'PeminjamanDisetujui'])->name('peminjaman.admin.disetujui');
    Route::get('/peminjaman-tolak', [PeminjamanAdminController::class, 'PeminjamanDitolak'])->name('peminjaman.admin.ditolak');
    Route::put('/peminjaman/{id}/update-status', [PeminjamanAdminController::class, 'updateStatus'])->name('peminjaman.updateStatus');

    Route::resource('kategori', KategoriController::class);
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
    Route::resource('sarana', SaranaController::class);
    Route::get('/sarana', [SaranaController::class, 'index'])->name('sarana.index');
    Route::post('/sarana', [SaranaController::class, 'store'])->name('sarana.store');
    Route::put('/sarana/{sarana}', [SaranaController::class, 'update'])->name('sarana.update');
    Route::delete('/sarana/{sarana}', [SaranaController::class, 'destroy'])->name('sarana.destroy');
    Route::get('/sarana/{idSarana}/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/sarana/{idSarana}/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/sarana/{idSarana}/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/sarana/{idSarana}/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    Route::delete('/sarana/{idSarana}/ruangan/delete-image/{id}', [RuanganController::class, 'deleteImage'])->name('ruangan.delete-image');

    Route::resource('jadwal', JadwalController::class);
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    Route::resource('penjaga', PenjagaController::class);
    Route::get('/penjaga', [PenjagaController::class, 'index'])->name('penjaga.index');
});

Route::group(['middleware' => ['checkRole:user']], function () {

     Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
        ->name('peminjaman.create');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');

    Route::post('/peminjaman/{peminjaman}/cancel', [PeminjamanController::class, 'cancel'])
        ->name('peminjaman.cancel');

    Route::get('/profile', [DetailProfileController::class, 'index'])->name('profile.index');

});

Route::group(['middleware' => ['checkRole:superadmin,pimpinan']], function () {
    Route::resource('pengguna', PenggunaController::class);
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
});

require __DIR__.'/auth.php';
