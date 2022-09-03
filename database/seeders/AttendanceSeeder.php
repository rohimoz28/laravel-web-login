<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AttendanceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Attendance::create([
      'user_id' => 1,
      'date' => Carbon::create('2022', '08', '30'),
      'start' => 1493931422000,
      'end' => 1493906522000
    ]);

    Attendance::create([
      'user_id' => 2,
      'date' => Carbon::create('2022', '08', '31'),
      'start' => 1493931422000,
      'end' => 1493906522000
    ]);

    Attendance::factory()->count(50)->create();
  }
}
