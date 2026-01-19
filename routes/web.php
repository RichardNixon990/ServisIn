<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
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


// Route::get('/profile', function () {
//     return view('User.profile');
// });

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::group(['prefix' => 'auth', 'as' => 'auth'], function(){
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterpage'])->name('register');
    Route::post('/loginAction', [AuthController::class, 'login'])->name('loginAction');
    Route::post('/registerAction', [AuthController::class, 'register'])->name('registerAction');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/store', [AuthController::class, 'store'])->name('store');
});

Route::group(['prefix' => 'order', 'as' => 'order', 'middleware' => ['auth.check']], function(){
    Route::get('/list', [OrderController::class, 'index'])->name('list');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::post('/show/{orders}', [OrderController::class, 'show'])->name('show');
    Route::post('/update/{orders}', [OrderController::class, 'update'])->name('update');
    Route::post('/cancel/{orders}', [OrderController::class, 'cancel'])->name('cancel');
    Route::delete('/delete/{orders}', [OrderController::class, 'delete'])->name('delete');
    Route::put('/payment/{payment}', [PaymentController::class, 'comfirmPayment'])->name('confirmPayment');
});

Route::group(['prefix' => 'rating', 'as' => 'rating', 'middleware' => ['auth.check']], function(){
    Route::get('/get', [RatingController::class, 'index'])->name('index');
    Route::post('/store', [RatingController::class, 'store'])->name('store');
    Route::delete('/delete/{ratings}', [RatingController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'technician', 'as' => 'technician', 'middleware' => ['technician']], function(){
    Route::get('/dashboard', [TechnicianController::class, 'Dashboard'])->name('Dashboard');
    Route::get('/my-order', [TechnicianController::class, 'myOrder'])->name('myOrder');
   Route::post('/update-status', [TechnicianController::class, 'updateStatus'])->name('updateStatus');
    Route::put('/takeorder/{orders}', [OrderController::class, 'takeorder'])->name('takeorder');
    Route::put('/completedOrder/{orders}', [OrderController::class, 'completedOrder'])->name('completedOrder');
});

Route::group(['prefix' => 'profile', 'as' => 'profile', 'middleware' => ['auth.check']], function(){
    Route::get('/view', [ProfileController::class, 'index'])->name('index');
    Route::put('/update/{users}', [ProfileController::class, 'update'])->name('update');
});
Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('updatePassword')->middleware('auth.check');

Route::group(['prefix' => 'admin', 'as' => 'admin', 'middleware' => ['auth.check']], function(){
    Route::post('/storeTechnician', [TechnicianController::class, 'store'])->name('storeTechnician');
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('Dashboard');
    Route::get('/storeUser', [AdminController::class, 'createUser'])->name('storeUser');
    Route::get('/showOrder{technician}', [AdminController::class, 'showTechnicianOrders'])->name('showOrder');
    Route::get('/report-order', [AdminController::class, 'exportPdf'])->name('exportPdf');
    Route::delete('/delete{technician}', [TechnicianController::class, 'delete'])->name('delete');
    Route::put('/comfirmPayment/{payments}', [PaymentController::class, 'adminConfirmPayment'])->name('updatePayment');
});
