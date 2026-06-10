<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $teacher = User::factory()->create([
            'name' => 'Clarity Mentor',
            'email' => 'teacher@example.com',
            'role' => 'teacher',
        ]);

        $course = Course::factory()
            ->for($teacher, 'teacher')
            ->published()
            ->create([
                'title' => 'Advanced UX Fundamentals',
                'completion_percentage' => 75,
                'last_saved_at' => now()->subHour(),
            ]);

        $module = $course->modules()->create([
            'title' => 'Module 1: Principles of Cognitive UX',
            'position' => 1,
        ]);

        $module->lessons()->createMany([
            ['title' => '1.1 Introduction to Neuro-Design', 'content_type' => 'youtube', 'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'position' => 1],
            ['title' => '1.2 Case Study: Reducing Cognitive Load', 'content_type' => 'youtube', 'metadata' => 'https://youtu.be/dQw4w9WgXcQ', 'position' => 2],
            ['title' => '1.3 Module Recap: Cognitive Biases', 'content_type' => 'youtube', 'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'position' => 3],
        ]);

        $course->modules()->createMany([
            ['title' => 'Module 2: Advanced Interaction Models', 'position' => 2],
            ['title' => 'Module 3: Prototyping for High Fidelity', 'position' => 3],
        ]);

        Course::factory()
            ->for($teacher, 'teacher')
            ->draft()
            ->create([
                'title' => 'Introduction to Python',
                'completion_percentage' => 20,
                'last_saved_at' => now()->subDays(2),
            ]);

        Course::factory()
            ->for($teacher, 'teacher')
            ->published()
            ->create([
                'title' => 'Digital Marketing 101',
                'completion_percentage' => 100,
                'last_saved_at' => now()->subWeek(),
            ]);
    }
}
