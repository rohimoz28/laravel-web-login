<?php

namespace App\Services;

interface AuthService
{
  public function login($data): ?bool;

  // public function register($data): void;
  // public function getUserID(string $email): ?object;
  //  public function getUser(string $email): ?object;
  //  public function updatePassword(string $email, string $password): void;
}
