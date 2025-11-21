<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/demo-page', [PageController::class, 'show']);
Route::get('/demo-page/download-zip', [PageController::class, 'downloadZIP']);