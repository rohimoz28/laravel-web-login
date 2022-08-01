<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

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

    $session = $this->request->session()->regenerate();
    return $session;
  }

  public function register($data): void
  {
    $validated = $this->request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed',
      'image' => 'image|file|max:2048',
    ]);

    if ($this->request->file('image')) {
      $validated['image'] = $this->request->file('image')->store('profile-pictures');
    } else {
      $validated['image'] = 'default.jpeg';
    }


    if ($this->request->file('image')) {
      $validated['image'] = $this->request->file('image')->store('profile-pictures');
    } else {
      $validated['image'] = 'default.jpeg';
    }

    $validated['password'] =  Hash::make($validated['password']);

    //input
    User::create($validated);
  }
}
