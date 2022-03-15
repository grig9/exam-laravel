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

Route::middleware('auth')->group(function() {
    Route::controller(HomeController::class)->group(function () {
        Route::get('users', 'show_users')
                ->name('show.users');

        Route::get('show/user/{id}', 'showUser');

        Route::get('status/{id}', 'show_user_status');
        Route::post('status/store', 'statusStore')
                ->name('status.store');

        Route::get('security/{id}', 'show_user_security');

        Route::get('media/{id}', 'imageForm');
        Route::post('store/image', 'storeImage');
        

        Route::get('edit/user/{id}', 'editForm');
        Route::post('update/user', 'updateUser');

        Route::get('delete/user/{id}', 'destroyUser');

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






