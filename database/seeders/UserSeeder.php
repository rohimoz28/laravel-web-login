<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::create([
      "name" => "UserTesting",
      "email" => "test@gmail.com",
      "password" => bcrypt("rahasia"),
    ]);

    User::create([
      "name" => "Yantina Larasati",
      "email" => "yantina@gmail.com",
      "password" => bcrypt("yantina"),
    ]);
  }
}
