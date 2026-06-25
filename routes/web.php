<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

// Rute Khusus Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/dashboard', function () {
        return view('kasir.dashboard');
    });
});

require __DIR__.'/auth.php';