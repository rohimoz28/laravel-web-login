<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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

  // public function register()
  // {
  //   return view('auth.register', [
  //     'title' => 'Registration'
  //   ]);
  // }
  //
  // public function doRegister(Request $request)
  // {
  //   $this->authService->register($request->all());
  //   //redirect
  //   return redirect('/')->with('success', 'Registration success, Please Login.');
  // }

  public function doLogin(Request $request)
  {
    $email = $request->input('email');
    $user = $this->authService->getUserID($email);

    if ($this->authService->login($request->all())) {

      $request->session()->put('id', $user->id);
      $request->session()->put('email', $user->email);

      return redirect()->intended('user');
    }

    //failed
    return back()->with('failed', 'Username or password wrong!');
  }

  public function checkEmail()
  {
    return view('auth.check-email', [
      'title' => 'Email Validation'
    ]);
  }

  public function doCheckEmail(Request $request)
  {
    $email = $request->input('email');
    $user =  $this->authService->getUser($email);

    if (!$user) {
      return redirect()->back()->with('failed', 'Email is not registered!');
    }

    if ($request->session()->has('email', 'question', 'answer')) {
      $request->session()->forget(['email', 'question', 'answer']);
    }

    $question = $user->question;
    $answer = $user->answer;

    $request->session()->put('email', $email);
    $request->session()->put('question', $question);
    $request->session()->put('answer', $answer);

    return redirect()->to('auth/secret-question');
  }

  public function secretQuestion(Request $request)
  {
    // $email = $request->session()->get('email');
    $question = $request->session()->get('question');

    return view('auth.secret-question', [
      'title' => 'Secret Question',
      'question' => $question
    ]);
  }

  public function checkAnswer(Request $request)
  {
    $email = $request->session()->get('email');
    $answer = $request->input('answer');

    $is_answer = $this->authService->checkAnswer($email, $answer);

    if (!$is_answer) {
      return redirect()->to('auth/secret-question')->with('failed', 'Your answer is wrong!');
    }

    return redirect()->to('auth/update-password');
    // return view('auth/update-password', [
    //   'title' => 'Update Password',
    //   'email' => $email,
    // ]);
  }

  public function updatePassword()
  {
    return view('auth/update-password', [
      'title' => 'Update Password'
    ]);
  }

  public function doUpdatePassword(Request $request)
  {
    //validasi
    $request->validate([
      'password' => 'required|confirmed',
      'password_confirmation' => 'required'
    ]);

    $email = $request->session()->get('email');
    $password = $request->input('password');

    $this->authService->updatePassword($email, $password);

    $request->session()->forget(['email', 'question', 'answer']);

    return redirect()->to('auth/index')->with('success', 'Password has been changed!');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
