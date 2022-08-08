<?php

namespace Tests\Feature;

use App\Models\User;
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
    $this->markTestSkipped();
  }

  public function testProfileUpdateEmailSuccess()
  {
    // assertTrue(true);
    $this->markTestSkipped();
  }

  public function testProfileUpdateEmailFailed()
  {
    $this->markTestSkipped();
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
    $this->markTestSkipped();
  }

  public function testChangePasswordFailed()
  {
    $this->markTestSkipped();
  }
}
