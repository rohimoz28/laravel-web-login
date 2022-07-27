<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.register',[
      'title' => 'Registration'
    ]);
  }

  public function doRegister()
  {

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
    return back()->with('loginFailed', 'Username or password wrong!');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
