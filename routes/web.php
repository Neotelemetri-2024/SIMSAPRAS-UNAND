<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeminjamanAdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjagaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Middleware\CheckRole;

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
});
Route::get('/home', function () {
    return view('home');
});
 Route::get('/sarana-prasarana', [SaranaController::class, 'daftarSarana'])->name('user.sarana');
 Route::get('/sarana-prasarana/{sarana}', [SaranaController::class, 'userShow'])->name('user.sarana.show');
Route::get('sarana-prasarana/ruangan/{ruangan}', [RuanganController::class, 'show'])
    ->name('ruangan.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['checkRole:superadmin,admin,pimpinan'], 'prefix' => 'admin'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('peminjaman', PeminjamanAdminController::class);
    Route::get('/peminjaman-masuk', [PeminjamanAdminController::class, 'PeminjamanMasuk'])->name('peminjaman.masuk');

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
    Route::get('/profile', function () {
        return view('user.dashboard');
    })->name('user.profile');

     Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
        ->name('peminjaman.create');
    
    // Menyimpan data peminjaman
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');
    
    // Menampilkan daftar peminjaman user
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');
    
    // Menampilkan detail peminjaman
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');
    
    // Membatalkan peminjaman
    Route::post('/peminjaman/{peminjaman}/cancel', [PeminjamanController::class, 'cancel'])
        ->name('peminjaman.cancel');

});

Route::group(['middleware' => ['checkRole:superadmin']], function () {
    Route::resource('pengguna', PenggunaController::class);
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
});

require __DIR__.'/auth.php';