<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseOrder>
 */
class CourseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'order_number' => 'ORD-'.strtoupper($this->faker->unique()->numerify('######')),
            'amount' => $this->faker->randomFloat(2, 10000, 500000),
            'status' => 'pending',
            'payment_method' => 'manual_transfer',
            'paid_at' => null,
        ];
    }
}
