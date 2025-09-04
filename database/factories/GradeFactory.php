<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->numberBetween(1, 50),
            'semester'   => $this->faker->randomElement(['Spring', 'Summer', 'Fall']),
            'marks'      => $this->faker->numberBetween(40, 100),
            'CH'         => $this->faker->randomFloat(1, 1, 4),
            'status'     => $this->faker->randomElement(['Pass', 'Fail']),
            'course_id'  => Course::inRandomOrder()->first()->id ?? Course::factory(),
        ];
    }
}
