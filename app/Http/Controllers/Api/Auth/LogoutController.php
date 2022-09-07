<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    // auth('api')->logout();
    $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

    if ($removeToken) {
      return response()->json([
        'success' => true,
        'message' => 'Logout successfully!',
      ]);
    }
  }
}
