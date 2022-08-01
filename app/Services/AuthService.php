<?php

namespace App\Services;

interface AuthService
{
  public function login($data): bool;

  public function register($data): void;
}
