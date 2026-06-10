<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $courses = $request->user()
            ->courses()
            ->with(['modules.lessons'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhereHas('modules', function ($query) use ($search): void {
                            $query->where('title', 'like', "%{$search}%")
                                ->orWhereHas('lessons', function ($query) use ($search): void {
                                    $query->where('title', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->orderByDesc('updated_at')
            ->get();

        $requestedCourseId = $request->integer('course');
        $activeCourse = $courses->firstWhere('id', $requestedCourseId) ?? $courses->first();

        return view('teacher.course-settings', compact('activeCourse', 'courses', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $courseNumber = $request->user()->courses()->count() + 1;

        $course = Course::create([
            'teacher_id' => $request->user()->id,
            'title' => "Untitled Course {$courseNumber}",
            'status' => 'draft',
            'completion_percentage' => 0,
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Course created successfully.');
    }

    public function updateSettings(Request $request, Course $course): RedirectResponse
    {
        $this->ensureTeacherOwnsCourse($request, $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course->update([
            ...$validated,
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course, 'tab' => 'settings'])
            ->with('success', 'Course settings updated successfully.');
    }

    public function saveDraft(Request $request, Course $course): RedirectResponse
    {
        $this->ensureTeacherOwnsCourse($request, $course);

        $course->update([
            'status' => 'draft',
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Draft saved successfully.');
    }

    public function publish(Request $request, Course $course): RedirectResponse
    {
        $this->ensureTeacherOwnsCourse($request, $course);

        $course->update([
            'status' => 'published',
            'completion_percentage' => max($course->completion_percentage, 75),
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Course published successfully.');
    }

    public function storeModule(Request $request, Course $course): RedirectResponse
    {
        $this->ensureTeacherOwnsCourse($request, $course);

        $position = $course->modules()->max('position') + 1;

        $course->modules()->create([
            'title' => "Module {$position}: New Learning Block",
            'position' => $position,
        ]);

        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Module added successfully.');
    }

    public function updateModule(Request $request, CourseModule $module): RedirectResponse
    {
        $course = $module->course;

        $this->ensureTeacherOwnsCourse($request, $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $module->update($validated);
        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Module updated successfully.');
    }

    public function moveModule(Request $request, CourseModule $module, string $direction): RedirectResponse
    {
        $course = $module->course;

        $this->ensureTeacherOwnsCourse($request, $course);
        abort_unless(in_array($direction, ['up', 'down'], true), 404);

        $operator = $direction === 'up' ? '<' : '>';
        $sortDirection = $direction === 'up' ? 'desc' : 'asc';

        $targetModule = $course->modules()
            ->where('position', $operator, $module->position)
            ->orderBy('position', $sortDirection)
            ->first();

        if ($targetModule) {
            [$modulePosition, $targetPosition] = [$module->position, $targetModule->position];

            $module->update(['position' => $targetPosition]);
            $targetModule->update(['position' => $modulePosition]);
            $course->update(['last_saved_at' => now()]);
        }

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Module order updated successfully.');
    }

    public function autoGenerateModule(Request $request, Course $course): RedirectResponse
    {
        $this->ensureTeacherOwnsCourse($request, $course);

        $position = $course->modules()->max('position') + 1;

        $module = $course->modules()->create([
            'title' => "Module {$position}: Generated Learning Path",
            'position' => $position,
        ]);

        $module->lessons()->createMany([
            ['title' => "{$position}.1 Concept Briefing", 'content_type' => 'youtube', 'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'position' => 1],
            ['title' => "{$position}.2 Practice Walkthrough", 'content_type' => 'youtube', 'metadata' => 'https://youtu.be/dQw4w9WgXcQ', 'position' => 2],
            ['title' => "{$position}.3 Mentor Recap", 'content_type' => 'youtube', 'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'position' => 3],
        ]);

        $course->update([
            'completion_percentage' => min(100, $course->completion_percentage + 10),
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Module generated successfully.');
    }

    public function storeLesson(Request $request, CourseModule $module): RedirectResponse
    {
        $course = $module->course;

        $this->ensureTeacherOwnsCourse($request, $course);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'youtube_url' => $this->youtubeUrlRules(),
        ]);

        $position = $module->lessons()->max('position') + 1;

        $module->lessons()->create([
            'title' => $validated['title'] ?? "{$module->position}.{$position} New Content",
            'content_type' => 'youtube',
            'metadata' => $validated['youtube_url'],
            'position' => $position,
        ]);

        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Content added successfully.');
    }

    public function updateLesson(Request $request, Lesson $lesson): RedirectResponse
    {
        $course = $lesson->module->course;

        $this->ensureTeacherOwnsCourse($request, $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => $this->youtubeUrlRules(),
        ]);

        $lesson->update([
            'title' => $validated['title'],
            'content_type' => 'youtube',
            'metadata' => $validated['youtube_url'],
        ]);

        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Content updated successfully.');
    }

    public function destroyModule(Request $request, CourseModule $module): RedirectResponse
    {
        $course = $module->course;

        $this->ensureTeacherOwnsCourse($request, $course);

        $module->delete();

        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Module removed successfully.');
    }

    public function destroyLesson(Request $request, Lesson $lesson): RedirectResponse
    {
        $course = $lesson->module->course;

        $this->ensureTeacherOwnsCourse($request, $course);

        $lesson->delete();

        $course->update([
            'last_saved_at' => now(),
        ]);

        return redirect()
            ->route('teacher.course-settings', ['course' => $course])
            ->with('success', 'Content removed successfully.');
    }

    private function ensureTeacherOwnsCourse(Request $request, Course $course): void
    {
        abort_if($course->teacher_id !== $request->user()->id, 403);
    }

    /**
     * @return array<int, mixed>
     */
    private function youtubeUrlRules(): array
    {
        return [
            'required',
            'url',
            'max:255',
            function (string $attribute, mixed $value, \Closure $fail): void {
                $host = parse_url((string) $value, PHP_URL_HOST);
                $host = is_string($host) ? mb_strtolower($host) : '';

                if (! in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be'], true)) {
                    $fail('The :attribute must be a valid YouTube URL.');
                }
            },
        ];
    }
}
