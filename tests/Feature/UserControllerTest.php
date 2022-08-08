<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  // protected UserService $service;
  //
  // public function __construct(UserService $service)
  // {
  //   $this->service = $service;
  // }

  public function testProfileUpdatePage()
  {
    $user = User::factory()->create([
      'password' => Hash::make($password = 'password'),
    ]);

    $this->post('auth/index', [
      'email' => $user->email,
      'password' => $password
    ]);

    $this->get('user/profile/' . $user->id)->assertSeeText('Edit Profile');
  }

  public function testChangePasswordPage()
  {
    $user = User::factory()->create([
      'password' => Hash::make($password = 'password'),
    ]);

    $this->post('auth/index', [
      'email' => $user->email,
      'password' => $password
    ]);

    $this->get('user/password/' . $user->id)->assertSeeText('Change Password');
  }
}
