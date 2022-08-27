<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecretQuestionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('secret_questions')->insert([
      'user_id' => 1,
      'question' => 'Where were you when you had your first kiss?',
      'answer' => 'bar'
    ]);

    DB::table('secret_questions')->insert([
      'user_id' => 2,
      'question' => 'Where were you when you had your first kiss?',
      'answer' => 'bar'
    ]);
  }
}
