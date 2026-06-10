<?php

namespace Database\Factories;

use App\Models\CourseModule;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_module_id' => CourseModule::factory(),
            'title' => fake()->sentence(5),
            'content_type' => 'youtube',
            'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'position' => fake()->numberBetween(1, 20),
        ];
    }

    public function youtube(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'youtube',
            'metadata' => 'https://youtu.be/dQw4w9WgXcQ',
        ]);
    }
}
