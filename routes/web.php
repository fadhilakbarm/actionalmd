<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;
use App\Http\Controllers\UserController;

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
    return view('auth/login');
});

Route::get('/logout', function () {
    Auth::logout();
    
    return redirect('/');
});

Route::get('auth/github', [GitHubController::class, 'gitRedirect']);
Route::get('auth/github/callback', [GitHubController::class, 'gitCallback']);

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => '/user', 'as' => 'user.'], function(){
        Route::resource('/', UserController::class)->except(['show'])->parameters(['' => 'user']);
        Route::get('/data', [UserController::class, 'data'])->name('data');
    });
});
