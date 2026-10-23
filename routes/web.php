<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BlogController;

Route::get('/', [LoginController::class, 'index']);

Route::post('/giris', [LoginController::class, 'giris']);

Route::post('/cikis', [LoginController::class, 'cikis']);

Route::get('/blog', [BlogController::class, 'index']);

Route::get('/makale/{id}', [BlogController::class, 'detay']);

Route::get('/makale-ekle', [BlogController::class, 'ekle']);

Route::post('/makale-kaydet', [BlogController::class, 'kaydet']);

Route::get('/makale/{id}/duzenle', [BlogController::class, 'duzenle']);

Route::post('/makale/{id}/guncelle', [BlogController::class, 'guncelle']);

Route::post('/makale/{id}/sil', [BlogController::class, 'sil']);
