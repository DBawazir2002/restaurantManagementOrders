<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;

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

Route::get('/',[VisitorController::class,'index']);

Route::controller(HomeController::class)->group(function(){
    Route::get('/home','index')->name('home')->middleware(['auth','verified']);
    Route::get('/mealDetails/{meal}','mealDetails')->name('meal_details');
    Route::post('/order/store','orderStore')->name('order.store')->middleware(['auth','verified']);
    Route::get('/order/show','showOrders')->name('orders')->middleware(['auth','verified']);

});

Route::get('/email/verify', function () {

    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $r) {
    $r->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function () {

    auth()->user()->sendEmailVerificationNotification();

    return back()->with('resent', 'Verification link sent ');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Auth::routes();

Route::prefix('admin')->middleware(['auth','can:access_admin_dashboard','verified'])->group(function(){
    Route::get('/', [HomeController::class, 'toAdmin'])->name('admin');
    Route::put('/order/{order}/status', [HomeController::class, 'changeStatus'])->name('order.status');
    Route::prefix('category')->controller(CategoryController::class)->group(function(){
        Route::get('/','index')->name('cat.index');
        Route::post('/store','store')->name('cat.store');
        Route::put('/update','update')->name('cat.update');
        Route::delete('/{category}','delete')->name('cat.delete');
    });
    Route::prefix('meal')->controller(MealController::class)->group(function(){
        Route::get('/','index')->name('meal.index');
        Route::get('/create','create')->name('meal.create');
        Route::post('/store','store')->name('meal.store');
        Route::get('/edit/{meal}','edit')->name('meal.edit');
        Route::put('/update','update')->name('meal.update');
        Route::delete('/delete/{meal}','destroy')->name('meal.delete');
    });
});

