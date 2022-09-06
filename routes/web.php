<?php

use App\Http\Controllers\AuthController;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Middleware\EnsureSession;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
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

Route::controller(AuthController::class)->group(function () {
  Route::get('/', 'login')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/', 'doLogin');

  Route::post('/logout', 'logout')->middleware([OnlyMemberMiddleware::class]);
});

Route::controller(UserController::class)->group(function () {
  Route::get('/user', 'index')->middleware([OnlyMemberMiddleware::class]);

  Route::get('/user/register', 'create')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/user/register', 'store');

  // future update to remove profil update
  // route::get('/user/profile/{id}', 'editProfile')->middleware([OnlyMemberMiddleware::class]);
  // route::put('/user/profile/{id}', 'updateProfile');
  //
  // route::get('/user/password', 'editPassword')->middleware([OnlyMemberMiddleware::class]);
  // route::put('/user/password', 'updatePassword');

  Route::get('/check-email', 'checkEmail')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/check-email', 'doCheckEmail');

  Route::get('/secret-question', 'secretQuestion')->middleware([OnlyGuestMiddleware::class]);;
  Route::post('/secret-question', 'checkAnswer');

  Route::get('/update-password', 'updatePassword')->middleware([OnlyGuestMiddleware::class]);;
  Route::post('/update-password', 'doUpdatePassword');
});

Route::controller(AttendanceController::class)->group(function () {
  Route::get('/attendance/absence', 'absence');
  Route::post('/attendance/absence', 'doAbsence');
  Route::get('/attendance/attendance-list', 'list');
});

Route::fallback(function () {
  return abort(404);
});
