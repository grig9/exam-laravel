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

Route::controller(RegisterController::class)->group(function () {
    Route::get('register_form', 'register_form')
            ->name('register.form');
    Route::post('register_user', 'register_user')
            ->name('register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login_form', 'create')
            ->name('login.form');
    Route::post('login', 'store')
            ->name('login');
});

Route::get('users', [HomeController::class, 'show_users'])
                ->name('show.users');

Route::middleware('auth')->group(function() {
    Route::controller(HomeController::class)->group(function () {
        
        Route::get('show/user/{id}', 'showUser')
                ->name('show.user');

        Route::get('status/{id}', 'show_user_status')
                ->name('show.user.status');
        Route::post('status/store', 'statusStore')
                ->name('status.store');

        Route::get('security/{id}', 'show_user_security')
                ->name('show.user.security');
        Route::post('user/security', 'securityStore')
                ->name('security.user');

        Route::get('media/{id}', 'imageForm')
                ->name('show.user.media');
        Route::post('store/image', 'storeImage')
                ->name('user.store.image');
        
        Route::get('edit/user/{id}', 'editForm')
                ->name('show.user.edit');
        Route::post('update/user', 'updateUser')
                ->name('user.update');

        Route::get('delete/user/{id}', 'deleteUser')
                ->name('delete.user');

        Route::get('logout', 'logout')
                ->name('logout');
    });
});

Route::group(['middleware' => ['auth', 'isadmin'], 'prefix' => 'admin', 'as' => 'admin.'], function()
{
    Route::get('/create/user/view', [HomeController::class,'createUserForm'])
            ->name('create.user.view');
    Route::post('/create/user', [HomeController::class,'createUser'])
            ->name('create.user');
});






