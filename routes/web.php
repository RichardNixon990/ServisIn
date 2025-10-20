<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::get('/home', function () {
    return view('home');
});

Route::group(['prefix' => 'auth', 'as' => 'auth' ], function(){
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterpage'])->name('register');
    Route::post('/loginAction', [AuthController::class, 'login'])->name('loginAction');
    Route::post('/registerAction', [AuthController::class, 'register'])->name('registerAction');
});
