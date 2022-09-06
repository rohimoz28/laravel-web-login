<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function checkEmail()
  {
    return view('auth.check-email', [
      'title' => 'Email Validation'
    ]);
  }

  public function doCheckEmail(Request $request)
  {
    // $user =  $this->authService->getUser($request->input('email'));
    return $user = $this->userService->getUser($request->input('email'));

    if (!$user) {
      return redirect()->back()->with('failed', 'Email is not registered!');
    }

    if ($request->session()->has('email', 'question', 'answer')) {
      $request->session()->forget(['email', 'question', 'answer']);
    }

    $question = $user->question;
    $answer = $user->answer;

    $request->session()->put('email', $request->input('email'));
    $request->session()->put('question', $question);
    $request->session()->put('answer', $answer);

    return redirect()->to('auth/secret-question');
  }

  public function testProfileUpdatePage()
  {
    $user = new User();
    $user->id = '1';
    $user->email = 'rohimuhamadd@gmail.com';
    $user->password = 'rahasia';

    $this->post('auth/index', [
      'email' => $user->email,
      'password' => $user->password,
    ]);

    $this->get('user/profile/' . $user->id)->assertSeeText("Edit Profile");
  }

  public function testProfileUpdateNameSuccess()
  {
    $user = User::find('11');
    $newName = fake()->name();

    $this->actingAs($user)->put('user/profile/' . $user->id, [
      'name' => $newName,
      'email' => 'bernier.adelbert@gmail.com',
    ]);

    $this->assertNotSame($newName, $user->name);
  }

  public function testProfileUpdateNameFailed()
  {
    $user = User::find('11');

    $this->actingAs($user)->put('user/profile/' . $user->id, [
      'name' => '',
      'email' => 'bernier.adelbert@gmail.com',
    ])->assertSessionHasErrors(['name']);
  }

  public function testChangePasswordPage()
  {
    $user = new User();
    $user->id = '1';
    $user->email = 'rohimuhamadd@gmail.com';
    $user->password = 'rahasia';

    $this->post('auth/index', [
      'email' => $user->email,
      'password' => $user->password
    ]);

    $this->get('user/password/' . $user->id)->assertSeeText('Change Password');
  }

  public function testChangePasswordSuccess()
  {
    $user = new User();
    $user->name = 'budi';
    $user->password = Hash::make('password123');
    $user->email = 'testing@gmail.com';

    $this->put('user/password/' . $user->id, [
      'currentPassword' => 'password123',
      'password' => 'passwordbaru',
      'password_confirmation' => 'passwordbaru'
    ]);

    $password = $user->password;

    $this->assertEquals($password, $user->password);
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

  // public function testChangePasswordFailedDueToOldPasswordInvalid()
  // {
  //   $user = new User();
  //   $user->name = 'budi';
  //   $user->password = Hash::make('password123');
  //   $user->email = 'testing@gmail.com';
  //
  //   $response = $this->put('user/password/' . $user->id, [
  //     'currentPassword' => 'salah',
  //     'password' => 'passwordbaru',
  //     'password_confirmation' => 'passwordbaru'
  //   ]);
  //
  //   $response->assertStatus(404);
  // }
}
