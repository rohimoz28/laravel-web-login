<?php

namespace Tests\Feature;

use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
  public function testLoginPage()
  {
    $this->get('auth/index')->assertSeeText('Login');
  }

  public function testLoginSuccess()
  {
    $this->post('auth/index', [
      'email' => 'rohimuhamadd@gmail.com',
      'password' => 'rahasia'
    ])
      ->assertRedirect('/user');
  }

  public function testLoginFailed()
  {
    $this->post('auth/index', [
      'email' => 'salah',
      'password' => 'salah'
    ])->assertRedirect('/');
  }

  public function testRegisterPage()
  {
    $this->get('auth/register')->assertSeeText('Registration Form');
  }

  public function testRegisterSuccess()
  {
    $this->post('auth/register', [
      'name' => 'Bagus',
      'email' => 'bagus@gmail.com',
      'password' => 'rahasia',
      'password_confirmation' => 'rahasia'
    ])->assertRedirect('/');
  }

  public function testRegisterFailed()
  {
    $this->post('auth/register', [
      'name' => 'Bagus',
      'email' => 'bagus@gmail.com',
      'password' => 'rahasia',
      'password_confirmation' => 'salah'
    ])->assertSessionHasErrors(['email', 'password']);
  }

  public function testForgotPasswordPage()
  {
    $this->get('auth/forgot')->assertSeeText('Forgot Password');
  }

  public function testForgotPasswordSuccess()
  {
    $this->put('auth/forgot', [
      'email' => 'rohimuhamadd@gmail.com',
      'password' => 'rahasia',
      'password_confirmation' => 'rahasia'
    ])->assertSessionHasNoErrors();

    $email = User::where('email', 'rohimuhamadd@gmail.com')->first();
    $email->refresh();
  }

  public function testForgotPasswordNoEmailRegistered()
  {
    $this->put('auth/forgot', [
      'email' => '',
      'password' => 'rahasia',
      'password_confirmation' => 'rahasia'
    ])->assertSessionHasErrors(['email']);
  }

  public function testForgotPasswordPasswordNotMatch()
  {
        $this->put('auth/forgot', [
      'email' => 'rohimuhamadd@gmail.com',
      'password' => 'rahasia',
      'password_confirmation' => 'salah'
    ])->assertSessionHasErrors(['password']);
  }
}
