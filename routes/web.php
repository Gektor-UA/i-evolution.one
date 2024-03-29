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

// Підключення платіжної системи
Route::post('/balance/depositAddress', [App\Http\Controllers\BalanceController::class, 'depositAddress'])->name('balance.depositAddress');
Route::post('/cpayconfirm', [App\Http\Controllers\Cpay\cPayControllerTake::class, 'cPayCon']);

// Вивід коштів
Route::post('/balance/withdraw', [App\Http\Controllers\BalanceController::class, 'withdraw'])->name('balance.withdraw');

Route::get('/', function () {
    return view('index');
});


//Route::get('/', [App\Http\Controllers\SecondUserController::class, 'index'])->name('second-users.index');
Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');

//Cabinet
Route::get('/cabinet', [App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');

//Registration
Route::get('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'index'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'create'])->name('register.create');

//IHealth
Route::get('/i-health/{hash}', [App\Http\Controllers\IHealthController::class, 'iHealth'])->name('iHealth');


//Logout
Route::post('/logout', [\App\Http\Controllers\Auth\RegistrationController::class, 'logout'])->name('logout');

//Login
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

//Admin
Route::get('/main', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('main');
Route::post("/withdraw/{withdrawId}/status", [\App\Http\Controllers\Admin\AdminController::class, 'updateStatus'])->name('updateStatus');

//Upload video
Route::post('/upload-video', [App\Http\Controllers\VideoController::class, 'uploadVideo'])->name('uploadVideo');
Route::post('/submit-youtube-link', [App\Http\Controllers\VideoController::class, 'uploadVideo'])->name('submitYouTubeLink');
Route::get('/download-video/{id}', [App\Http\Controllers\VideoController::class, 'downloadVideo'])->name('downloadVideo');
Route::post('/approve-video/{id}', [App\Http\Controllers\VideoController::class, 'approveVideo'])->name('approveVideo');
Route::post('/reject-video/{id}', [App\Http\Controllers\VideoController::class, 'rejectVideo'])->name('rejectVideo');

//Вибір програми
Route::post('/save-package', [\App\Http\Controllers\ProgramsUserController::class, 'savePackage'])->name('savePackage');
Route::get('/get-selected-program', [\App\Http\Controllers\ProgramsUserController::class, 'getSelectedProgram'])->name('getSelectedProgram');
