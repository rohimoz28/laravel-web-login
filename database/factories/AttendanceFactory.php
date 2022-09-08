<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $events = $this->faker->dateTimeBetween('-240 days', '-1 days');

    return [
      'user_id' => $this->faker->numberBetween(1, 2),
      'date' => $events,
      'start' => 1493931422000,
      'end' => 1493906522000
    ];
  }
}
