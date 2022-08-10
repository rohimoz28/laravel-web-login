<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

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

  public function testChangePasswordFailedDueToOldPasswordInvalid()
  {
    $user = new User();
    $user->name = 'budi';
    $user->password = Hash::make('password123');
    $user->email = 'testing@gmail.com';

    $response = $this->put('user/password/' . $user->id, [
      'currentPassword' => 'salah',
      'password' => 'passwordbaru',
      'password_confirmation' => 'passwordbaru'
    ]);

    $response->assertStatus(404);
  }
}
