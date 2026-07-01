<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\MenuController;
use App\Http\Controllers\RetailController;
use App\Http\Controllers\PosController;

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
    Route::get('/admin/dashboard', function () {
        $menus = \App\Models\Menu::all();
        return view('admin.dashboard', compact('menus'));
    })->name('admin.dashboard');
    
    // Rute ke halaman kelola menu yang baru kita buat
    Route::get('/admin/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('/admin/menu', [\App\Http\Controllers\MenuController::class, 'store'])->name('admin.menu.store');
    Route::delete('/admin/menu/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');
    Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');

    //rute retail dan beans kopi
    // Rute Etalase Retail & Biji Kopi
	Route::get('/admin/retail', [RetailController::class, 'index'])->name('admin.retail.index');
	Route::post('/admin/retail', [RetailController::class, 'store'])->name('admin.retail.store');
	Route::put('/admin/retail/{id}', [RetailController::class, 'update'])->name('admin.retail.update');
	Route::delete('/admin/retail/{id}', [RetailController::class, 'destroy'])->name('admin.retail.destroy');
	});

// Rute Khusus Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/pos/index', function () {
        return redirect()->route('pos.index');
    });

    // 2. Rute Aplikasi POS Kasir (Ini yang memanggil PosController)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    //simpan dan riwayet
	Route::post('/pos/simpan',  [PosController::class, 'simpan'])->name('pos.simpan');
	Route::get('/pos/riwayat',  [PosController::class, 'riwayat'])->name('pos.riwayat');





	Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

});

require __DIR__.'/auth.php';