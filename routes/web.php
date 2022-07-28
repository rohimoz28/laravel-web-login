<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
  return view('auth/index');
});

Route::resource('user', UserController::class)->except('destroy', 'create', 'store', 'show');

Route::controller(AuthController::class)->group(function () {
  Route::get('/auth/index', 'index');
  Route::post('/auth/index', 'doLogin');
  Route::get('/auth/register', 'register');
  Route::post('/auth/register', 'doRegister');
  Route::get('/auth/logout', 'logout');
  Route::get('/auth/forgot', 'forgotPassword');
  Route::post('/auth/forgot', 'forgotPassword');
});

Route::controller(UserController::class)->group(function(){
  route::get('/user/profile/{id}','editProfile');
  route::put('/user/profile/{id}','updateProfile');
  route::get('/user/password/{id}','editPassword');
  route::put('/user/password/{id}','updatePassword');
});
