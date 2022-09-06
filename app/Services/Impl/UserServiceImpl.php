<?php

namespace App\Services\Impl;

use App\Models\SecretQuestion;
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

  // public function register($data)
  // {
  //   $validated = $this->request->validate([
  //     'name' => 'required',
  //     'email' => 'required|email|unique:users',
  //     'password' => 'required|confirmed',
  //     'question' => 'notIn:0',
  //     'answer' => 'required',
  //     'image' => 'image|file|max:2048',
  //   ], [
  //     'question.not_in' => 'You need to choose the :attribute'
  //   ]);
  //
  //   if ($this->request->file('image')) {
  //     $validated['image'] = $this->request->file('image')->store('profile-pictures');
  //   } else {
  //     $validated['image'] = 'default.jpeg';
  //   }
  //
  //   if ($this->request->file('image')) {
  //     $validated['image'] = $this->request->file('image')->store('profile-pictures');
  //   } else {
  //     $validated['image'] = 'default.jpeg';
  //   }
  //
  //   //input
  //   DB::beginTransaction();
  //   try {
  //     $user = User::create([
  //       'name' => $validated['name'],
  //       'email' => $validated['email'],
  //       'password' => Hash::make($validated['password']),
  //       'image' => $validated['image']
  //     ]);
  //
  //     $last_inserted_ID = $user->id;
  //
  //     SecretQuestion::create([
  //       'user_id' => $last_inserted_ID,
  //       'question' => $validated['question'],
  //       'answer' => $validated['answer']
  //     ]);
  //     DB::commit();
  //   } catch (\Exception $exception) {
  //     DB::rollBack();
  //     return $exception->getMessage();
  //   }
  // }

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

    // $validateData = $this->request->validate($rules);

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
