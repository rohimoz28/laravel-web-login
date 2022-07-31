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
    $oldPassword = DB::table('users')->where('id', $id)->value('password');

    // check old password and hashing it
    if (Hash::check($data['currentPassword'], $oldPassword)) {
      $data['password'] =  Hash::make($data['password']);
      $data = ['password' => $data['password']];
    }

    User::where('id', $id)->update($data);
  }
}
