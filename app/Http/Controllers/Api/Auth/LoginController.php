<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(AuthLoginRequest $request)
  {
    $credentials = $request->only('email', 'password');

    if (!$token = auth()->guard('api')->attempt($credentials)) {
      return response()->json([
        'success' => false,
        'message' => 'Email atau password anda salah!',
      ]);
    }

    return response()->json([
      'success' => true,
      'user' => auth()->guard('api')->user(),
      'token' => $token,
    ]);
  }
}
