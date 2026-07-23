<?php

use Illuminate\Support\Facades\Route;

// Redirect halaman utama langsung ke /menu (atau panggil controller/view menu)
Route::get('/', function () {
    return redirect('/menu');
});

// Route untuk /menu, /event, dan /area
Route::get('/menu', function () {
    return view('menu'); // Sesuaikan dengan nama file view kamu (misal: resources/views/menu.blade.php)
});

Route::get('/event', function () {
    return view('event'); // Sesuaikan dengan view event kamu
});

Route::get('/area', function () {
    return view('area'); // Sesuaikan dengan view area kamu
});
