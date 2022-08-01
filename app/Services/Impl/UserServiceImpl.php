<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
  protected Request $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function updateProfile($data, $id): void
  {
    $currentEmail = DB::table('users')->where('id', $id)->value('email');

    if ($currentEmail != $data['email']) {
      $rules = [
        'name' => 'required',
        'email' => 'required|unique:users',
      ];
    } else {
      $rules = [
        'name' => 'required',
      ];
    };

    $validated = $this->request->validate($rules);

    User::where('id', $id)->update($validated);
  }

  public function updatePassword($data, $id): void
  {
    $validated = $this->request->validate([
      'currentPassword' => 'required|current_password:web',
      'password' => 'required|confirmed',
      'password_confirmation' => 'required'
    ], [
      'password.confirmed' => 'Password not match!',
      'password.current_password' => 'Wrong Current Password'
    ]);

    //hash new password
    $newPassword = Hash::make($validated['password']);

    $user = User::find($id);
    $user->password = $newPassword;
    $user->save();
  }
}
