<?php
namespace App\Services;

interface UserService{
  public function register($data);
  public function updateProfile($data,$id): void;
  public function updatePassword($data, $id): void;
}
