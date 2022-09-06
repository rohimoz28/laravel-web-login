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
      "name" => "Admin",
      "username" => 'admin',
      "email" => "admin@gmail.com",
      "password" => bcrypt("rahasia"),
    ]);

    User::create([
      "name" => "Yantina Larasati",
      "username" => 'yantina',
      "email" => "yantina@gmail.com",
      "password" => bcrypt("yantina"),
    ]);
  }
}
