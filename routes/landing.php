<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// Route publik (dokumen perancangan, bagian 7.1)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dokumentasi', [DocumentationController::class, 'index'])->name('dokumentasi.index');
Route::get('/dokumentasi/{slug}', [DocumentationController::class, 'show'])->name('dokumentasi.show');
Route::get('/dokumentasi/{slug}/unduh', [DocumentationController::class, 'download'])
    ->middleware('throttle:30,1')
    ->name('dokumentasi.unduh');

Route::get('/struktur/{generation}', [MemberController::class, 'byGeneration'])->name('struktur.show');
