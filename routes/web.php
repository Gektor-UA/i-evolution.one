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


Route::get('/', [App\Http\Controllers\SecondUserController::class, 'index'])->name('second-users.index');
//Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');

//Cabinet
Route::get('/cabinet', [App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');

//Registration
Route::get('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'index'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'create'])->name('register.create');

//IHealth
//Route::get('/iHealth', [App\Http\Controllers\IHealthController::class, 'index'])->name('iHealth');
Route::get('/iHealth/{hash}', [App\Http\Controllers\IHealthController::class, 'iHealth'])->name('iHealth');


//Logout
Route::post('/logout', [\App\Http\Controllers\Auth\RegistrationController::class, 'logout'])->name('logout');

//Login
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

//Admin
Route::get('/main', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('main');

//Upload video
Route::post('/upload-video', [App\Http\Controllers\IHealthController::class, 'uploadVideo'])->name('uploadVideo');
Route::post('/submit-youtube-link', [App\Http\Controllers\IHealthController::class, 'submitYouTubeLink'])->name('submitYouTubeLink');
