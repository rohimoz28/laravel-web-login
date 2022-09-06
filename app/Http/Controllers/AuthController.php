<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
// use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  // private AuthService $authService;
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    // $this->authService = $authService;
    $this->userService = $userService;
  }

  public function login()
  {
    return view('auth.login', [
      'title' => 'Login',
    ]);
  }

  public function doLogin(AuthLoginRequest $request)
  {

    $credentials = $request->only('username', 'password');
    if (!Auth::attempt($credentials)) {
      // Login failed
      return back()->with('failed', 'Username or password wrong!');
    }

    // Login success
    $user = $this->userService->getUser($request->input('username'));
    $request->session()->put('id', $user->id);

    return redirect()->intended('user');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
