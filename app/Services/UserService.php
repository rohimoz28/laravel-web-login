<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
  public function getUser(string $email): ?object;

  public function userQuestion(string $email): ?object;

  public function updateProfile($data, $id): void; //deactivate

  // public function updatePassword($data, $id): void; //deactivate
}
