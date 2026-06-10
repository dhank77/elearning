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
        $contentType = fake()->randomElement(['video', 'document', 'quiz']);

        return [
            'course_module_id' => CourseModule::factory(),
            'title' => fake()->sentence(5),
            'content_type' => $contentType,
            'metadata' => match ($contentType) {
                'video' => fake()->numberBetween(6, 24).':'.fake()->numberBetween(10, 59).' Video',
                'document' => 'PDF Resource',
                'quiz' => fake()->numberBetween(5, 15).' Questions',
                default => null,
            },
            'position' => fake()->numberBetween(1, 20),
        ];
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'video',
            'metadata' => '12:45 Video',
        ]);
    }

    public function document(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'document',
            'metadata' => 'PDF Resource',
        ]);
    }

    public function quiz(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'quiz',
            'metadata' => '10 Questions',
        ]);
    }
}
