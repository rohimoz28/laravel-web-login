<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
    //validation
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed',
    ]);
    $validated['password'] =  Hash::make($validated['password']);
    //input
    User::create($validated);
    //redirect
    return redirect('/')->with('success', 'Registration success, Please Login.');
  }

  public function doLogin(Request $request)
  {
    //validate
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    //check
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
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

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
