<?php

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
    return view('index');
});



Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');






Route::post('/upload-video', [App\Http\Controllers\IHealthController::class, 'uploadVideo'])->name('uploadVideo');
Route::post('/submit-youtube-link', [App\Http\Controllers\IHealthController::class, 'submitYouTubeLink'])->name('submitYouTubeLink');
