<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserServiceImpl implements UserService
{
  protected Request $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function getUser(string $username): ?User
  {
    return User::where('username', $username)->first();
  }

  public function userQuestion(string $email): ?object
  {
    $user = DB::table('users')
      ->join('secret_questions', 'users.id', '=', 'secret_questions.user_id')
      ->select('users.*', 'secret_questions.*')
      ->where('users.email', '=', $email)
      ->first();

    return $user;
  }

  // user profile update name & email
  public function updateProfile($data, $id): void
  {
    $currentEmail = DB::table('users')->where('id', $id)->value('email');

    if ($currentEmail != $data['email']) {
      $validated = $this->request->validate([
        'name' => 'required',
        'email' => 'required|unique:users',
        'image' => 'image|file|max:1024',
      ]);
    } else {
      $validated = $this->request->validate([
        'name' => 'required',
        'image' => 'image|file|max:1024',
      ]);
    };

    if ($this->request->hasFile('image')) {
      if ($this->request->oldImage) {
        Storage::delete($this->request->oldImage);
      }

      $validated['image'] = $this->request->file('image')->store('picture-profiles');
    }

    User::where('id', $id)->update($validated);
  }

  // user profile update password
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
