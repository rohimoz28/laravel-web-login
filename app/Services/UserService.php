<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
  public function getUser(string $username): ?User;

  public function userQuestion(string $email): ?object;

  // public function register($request); // not use

  public function updateProfile($data, $id): void;

  public function updatePassword($data, $id): void;
}
