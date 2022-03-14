<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::controller(RegisterController::class)->group(function () {
    Route::get('register_form', 'register')->name('register');
    Route::post('register', 'create');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login_form', 'create');
    Route::post('login', 'store')->name('login');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('users', 'show_users');
    Route::get('user/{id}', 'show_user');
    Route::get('status/{id}', 'show_user_status');
    Route::get('security/{id}', 'show_user_security');
    Route::get('media/{id}', 'image_form');
    Route::get('edit_user/{id}', 'edit_form');

    Route::get('create_user_form', 'create_user_form');
    Route::get('create_user', 'create_user');
});



Route::get('logout', [])->name('logout');


