<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//   return view('auth/index');
// });
Route::get('/', [HomeController::class, 'home']);

Route::resource('user', UserController::class)->except('destroy', 'create', 'store', 'show');

Route::controller(AuthController::class)->group(function () {
  Route::get('/auth/index', 'index')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/auth/index', 'doLogin')->middleware([OnlyGuestMiddleware::class]);
  // Route::get('/auth/register', 'register')->middleware([OnlyGuestMiddleware::class]);
  // Route::post('/auth/register', 'doRegister')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/auth/logout', 'logout')->middleware([OnlyMemberMiddleware::class]); //onlyMember
  Route::get('/auth/check-email', 'checkEmail');
  Route::post('/auth/check-email', 'doCheckEmail');
  Route::get('/auth/secret-question', 'secretQuestion')->middleware([EnsureSession::class]);
  Route::post('/auth/secret-question', 'checkAnswer');
  Route::get('/auth/update-password', 'updatePassword')->middleware([EnsureSession::class]);
  Route::post('/auth/update-password', 'doUpdatePassword');
});

Route::controller(UserController::class)->group(function () {
  Route::get('/user/register', 'create')->middleware([OnlyGuestMiddleware::class]);
  Route::post('/user/register', 'store')->middleware([OnlyGuestMiddleware::class]);
  route::get('/user/profile/{id}', 'editProfile')->middleware([OnlyMemberMiddleware::class]);
  route::put('/user/profile/{id}', 'updateProfile');
  route::get('/user/password/{id}', 'editPassword')->middleware([OnlyMemberMiddleware::class]);
  route::put('/user/password/{id}', 'updatePassword');
});

Route::controller(AttendanceController::class)->group(function () {
  // Route::get('/attendance/absence/{id}', 'absence');
  Route::get('/attendance/absence', 'absence');
  Route::post('/attendance/absence', 'doAbsence');
  // Route::get('/attendance/attendance-list/{id}', 'list');
  Route::get('/attendance/attendance-list', 'list');
  // Route::get('/attendance/search', 'search');
});

Route::fallback(function () {
  return abort(404);
});
