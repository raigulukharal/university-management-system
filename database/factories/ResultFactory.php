<?php

namespace Database\Factories;

use App\Models\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition()
    {
        return [
            'roll_no' => $this->faker->unique()->numerify('STU#####'),
            'student_name' => $this->faker->name,
            'course_name' => $this->faker->randomElement(['Mathematics', 'Physics', 'Chemistry', 'Biology']),
            'obtained_mark' => $this->faker->numberBetween(50, 100),
            'credit_hour' => $this->faker->randomElement([3.0, 4.0]),
            'gp' => $this->faker->randomFloat(2, 2.0, 4.0),
            'gpa' => $this->faker->randomFloat(2, 6.0, 16.0),
            'session_id' => '2024',
        ];
    }
}