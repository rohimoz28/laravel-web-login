<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
  public function getUser(string $username): ?User;

  public function register($data);

  public function updateProfile($data, $id): void;

  public function updatePassword($data, $id): void;
}
