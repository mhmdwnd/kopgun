<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\MenuController;
use App\Http\Controllers\RetailController;
use App\Http\Controllers\PosController;
// use App\Http\Controllers\EventController;
// use App\Http\Controllers\AreaController;

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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
// Rute Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Rute ke halaman kelola menu 
    Route::get('/admin/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('/admin/menu', [\App\Http\Controllers\MenuController::class, 'store'])->name('admin.menu.store');
    Route::delete('/admin/menu/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');
    Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');

    // Rute Etalase Retail & Biji Kopi
	Route::get('/admin/retail', [RetailController::class, 'index'])->name('admin.retail.index');
	Route::post('/admin/retail', [RetailController::class, 'store'])->name('admin.retail.store');
	Route::put('/admin/retail/{id}', [RetailController::class, 'update'])->name('admin.retail.update');
	Route::delete('/admin/retail/{id}', [RetailController::class, 'destroy'])->name('admin.retail.destroy');
	});

    //event dan area
    Route::get('/admin/event', [\App\Http\Controllers\EventController::class, 'index'])->name('admin.event.index');
    Route::post('/admin/event', [\App\Http\Controllers\EventController::class, 'store'])->name('admin.event.store');
    Route::put('/admin/event/{id}', [\App\Http\Controllers\EventController::class, 'update'])->name('admin.event.update');
    Route::delete('/admin/event/{id}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('admin.event.destroy');

    Route::get('/admin/area', [\App\Http\Controllers\AreaController::class, 'index'])->name('admin.area.index');
    Route::post('/admin/area', [\App\Http\Controllers\AreaController::class, 'store'])->name('admin.area.store');
    Route::put('/admin/area/{id}', [\App\Http\Controllers\AreaController::class, 'update'])->name('admin.area.update');
    Route::delete('/admin/area/{id}', [\App\Http\Controllers\AreaController::class, 'destroy'])->name('admin.area.destroy');

    //rute laporan keuangan
    Route::get('/admin/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('admin.laporan.index');

// Rute Khusus Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/pos/index', function () {
        return redirect()->route('pos.index');
    });

    // 2. Rute Aplikasi POS Kasir (Ini yang memanggil PosController)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    //simpan dan riwayet
	Route::post('/pos/simpan-transaksi',  [PosController::class, 'simpanTransaksi'])->name('pos.simpan');
    Route::post('/pos/kas', [PosController::class, 'simpanKas'])->name('pos.kas');
	Route::get('/pos/riwayat',  [PosController::class, 'riwayatTransaksi'])->name('pos.riwayat');





	Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

});

Route::get('/menu', [\App\Http\Controllers\PublicMenuController::class, 'index'])->name('menu.public');
Route::get('/event', [\App\Http\Controllers\PublicEventController::class, 'index'])->name('event.public');
Route::get('/area', [\App\Http\Controllers\PublicAreaController::class, 'index'])->name('area.public');

require __DIR__.'/auth.php';