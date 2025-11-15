<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TechnicianController;


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


Route::get('/profile', function () {
    return view('User.profile');
});


Route::get('/', [LandingController::class, 'index'])->name('landing');
// Route::get('/', [OrderController::class, ''])->name('home')->middleware('auth.check');

Route::group(['prefix' => 'auth', 'as' => 'auth' ], function(){
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterpage'])->name('register');
    Route::post('/loginAction', [AuthController::class, 'login'])->name('loginAction');
    Route::post('/registerAction', [AuthController::class, 'register'])->name('registerAction');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::group(['prefix' => 'order', 'as' => 'order', 'middleware' => ['auth.check']], function(){
    Route::get('/list', [OrderController::class, 'index'])->name('list');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::put('/takeorder/{orders}', [OrderController::class, 'takeorder'])->name('takeorder');
    Route::post('/cancel/{orders}', [OrderController::class, 'cancel'])->name('cancel');
});
Route::group(['prefix' => 'rating', 'as' => 'rating' ,  'middleware' => ['auth.check']], function(){
    Route::get('/get', [RatingController::class, 'index'])->name('index');
    Route::post('/store', [RatingController::class, 'store'])->name('store');
    Route::delete('/delete/{ratings}', [RatingController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'technician', 'as' => 'technician' ,  'middleware' => ['technician']], function(){
    Route::get('/dashboard', [TechnicianController::class, 'Dashboard'])->name('Dashboard');
    Route::get('/my-order', [TechnicianController::class, 'myOrder'])->name('myOrder');
});
Route::post('/store', [TechnicianController::class, 'store'])->name('store');
Route::get('/test', [TechnicianController::class, 'create'])->name('create');
// ->middleware('Technician')
