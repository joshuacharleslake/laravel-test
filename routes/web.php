<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //User Profile
    Route::view('/profile', 'profile')->name('profile');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
        ->name('profile.update');

});

Route::group(['middleware' => ['admin'], ['auth']],     function() {

    //Admin Users
    Route::resource('/users', \App\Http\Controllers\Users\UsersController::class);

    //Admin Client Users
    Route::resource('/client-users', \App\Http\Controllers\ClientUsers\ClientUsersController::class, ['parameters' => [
        'create' => 'client_id'
    ]]);

    //Admin Clients
    Route::resource('/clients', \App\Http\Controllers\Clients\ClientsController::class);

    //Admin Quotes
    Route::resource('/quotes', \App\Http\Controllers\Quotes\QuotesController::class);

});

require __DIR__.'/auth.php';
