<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{

  protected Request $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function login($data): bool
  {
    $credentials = $this->request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    //check
    if (Auth::attempt($credentials) == null) {
      return false;
    }

    return true;
    // $session = $this->request->session()->regenerate();
    // return $session;
  }

  public function getUserID(string $email): ?object
  {
    $user = DB::table('users')
      ->where('email', $email)
      ->first();

    return $user;
  }

  public function getUser($email): ?object
  {
    // $user = DB::table('users')->where('email', $email)->first();
    $user = DB::table('users')
      ->select('users.id', 'email', 'question', 'answer')
      ->join('secret_questions', 'secret_questions.user_id', '=', 'users.id')
      ->where('users.email', $email)
      ->first();

    return $user;
  }

  public function checkAnswer($email, $answer): bool
  {
    $user = $this->getUser($email);

    return ($user->answer === $answer) ? true : false;
  }

  public function updatePassword(string $email, string $password): void
  {
    $getUser = $this->getUser($email);
    $getUserID = $getUser->id;

    $user = User::find($getUserID);
    $user->password = Hash::make($password);
    $user->save();
  }
}
