<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;

Route::get('/', function () {
    return view('public.home');
})->name('home');

// Halaman login admin sementara
Route::get('/admin/login', function () {
    return 'Halaman login admin sedang dalam pengembangan.';
})->name('admin.login');

//halaman pengaduan
Route::get('/pengaduan', [ComplaintController::class, 'create'])
    ->name('complaints.create');

Route::post('/pengaduan', [ComplaintController::class, 'store'])
    ->name('complaints.store');

Route::get('/pengaduan/berhasil', function () {
    if (!session()->has('complaint_ticket') ||
        !session()->has('complaint_access_code')) {
        return redirect()->route('complaints.create');
    }

    return view('public.complaints.success');
})->name('complaints.success');