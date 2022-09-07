<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\User\CreateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::post('/user/create', CreateController::class)->name('register');
/**
 * route "/user"
 * @method "GET"
 */

// register
// show
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::middleware('auth:api')->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});

