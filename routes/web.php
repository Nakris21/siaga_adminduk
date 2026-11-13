<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;

Route::get('/', function () {
    return view('public.home');
})->name('home');


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

// Autentikasi Admin
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])
        ->name('admin.login');

    Route::post('/admin/login', [LoginController::class, 'store'])
        ->name('admin.login.store');
});

// Halaman Admin yang membutuhkan autentikasi
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/pengaduan', [AdminComplaintController::class, 'index'])
    ->name('complaints.index');

    Route::get('/pengaduan/{complaint}', [AdminComplaintController::class, 'show'])
        ->name('complaints.show');

    Route::post('/pengaduan/{complaint}/balas', [AdminComplaintController::class, 'reply'])
        ->name('complaints.reply');

    Route::patch('/pengaduan/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])
        ->name('complaints.status');

    Route::get(
        '/pengaduan/{complaint}/lampiran/{attachment}',
        [AdminComplaintController::class, 'showAttachment']
    )->name('complaints.attachments.show');

});
