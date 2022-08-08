<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  private AuthService $authService;

  public function __construct(AuthService $authService)
  {
    $this->authService = $authService;
  }

  public function index()
  {
    return view('auth.index', [
      'title' => 'Login',
    ]);
  }

  public function register()
  {
    return view('auth.register', [
      'title' => 'Registration'
    ]);
  }

  public function doRegister(Request $request)
  {
    $this->authService->register($request->all());
    //redirect
    return redirect('/')->with('success', 'Registration success, Please Login.');
  }

  public function doLogin(Request $request)
  {
    $user = $request->input('name');

    if ($this->authService->login($request->all())) {

      $request->session()->put('user', $user);

      return redirect()->intended('user');
    }

    //failed
    return back()->with('failed', 'Username or password wrong!');
  }

  public function forgotPassword()
  {
    return view('auth.forgot-password', [
      'title' => 'Forgot Password'
    ]);
  }

  public function updatePassword(Request $request)
  {
    //validasi
    $validated = $request->validate([
      'email' => 'required',
      'password' => 'required|confirmed'
    ]);

    //cek email
    $email = User::where('email', $validated['email'])->first();

    if ($email == null) {
      return back()->with('failed', 'Wrong Email!');
    }
    //hash
    $validated['password'] =  Hash::make($validated['password']);
    $data = [
      'password' => $validated['password'],
    ];
    //update password
    User::where('id', $email->id)
      ->update($data);
    //redirect
    return redirect('/')->with('success', 'Password has been changed!');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
