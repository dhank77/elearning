<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('DISKON##??'),
            'discount_percentage' => fake()->randomFloat(2, 5, 50),
            'description' => fake()->optional()->sentence(),
            'is_active' => fake()->boolean(80),
            'expires_at' => fake()->optional()->dateTimeBetween('now', '+6 months'),
        ];
    }
}
