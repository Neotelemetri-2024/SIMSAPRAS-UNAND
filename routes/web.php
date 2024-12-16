<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaranaController;
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



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['checkRole:superadmin,admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/kategori', function () {
        return view('admin.kategori');
    })->name('admin.kategori');

    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
  Route::resource('sarana', SaranaController::class);
   Route::get('/sarana', [SaranaController::class, 'index'])->name('sarana.index'); // Menampilkan halaman daftar sarana
    Route::post('/sarana', [SaranaController::class, 'store'])->name('sarana.store'); // Menyimpan data sarana baru
    Route::put('/sarana/{sarana}', [SaranaController::class, 'update'])->name('sarana.update'); // Memperbarui data sarana
    Route::delete('/sarana/{sarana}', [SaranaController::class, 'destroy'])->name('sarana.destroy'); // Menghapus data sarana
    
  

});


Route::group(['middleware' => ['checkRole:user']], function () {
    Route::get('/profile', function () {
        return view('user.dashboard');
    })->name('user.profile');

    // Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});






require __DIR__.'/auth.php';