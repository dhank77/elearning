<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $enrolledCourses = $user->enrolledCourses()
            ->with(['teacher', 'modules'])
            ->withCount('modules')
            ->orderByDesc('course_orders.paid_at')
            ->get();

        $paidOrders = $user->courseOrders()
            ->where('status', 'paid')
            ->with('course')
            ->orderByDesc('paid_at')
            ->get();

        $totalSpent = $paidOrders->sum('amount');

        return view('student.my-courses', compact(
            'enrolledCourses',
            'paidOrders',
            'totalSpent',
        ));
    }

    public function show(Request $request, Course $course, ?int $lesson = null): View|RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user->enrolledCourses()->where('courses.id', $course->id)->exists(),
            403,
            'Anda belum terdaftar di kursus ini.',
        );

        $course->load(['modules.lessons']);

        $allLessons = $course->modules->pluck('lessons')->flatten()->sortBy('position');
        $totalLessons = $allLessons->count();

        if ($totalLessons === 0) {
            return view('student.learn', [
                'course' => $course,
                'activeLesson' => null,
                'flatLessons' => collect(),
                'totalLessons' => 0,
                'currentIndex' => -1,
                'prevLesson' => null,
                'nextLesson' => null,
                'youtubeId' => null,
            ]);
        }

        $activeLesson = $lesson
            ? $allLessons->firstWhere('id', $lesson)
            : $allLessons->first();

        if (! $activeLesson) {
            $activeLesson = $allLessons->first();
        }

        $flatLessons = $allLessons->values();
        $currentIndex = $flatLessons->search(fn ($l) => $l->id === $activeLesson->id);

        $prevLesson = $currentIndex > 0 ? $flatLessons->get($currentIndex - 1) : null;
        $nextLesson = $currentIndex < $totalLessons - 1 ? $flatLessons->get($currentIndex + 1) : null;

        $youtubeId = $this->extractYouTubeVideoId($activeLesson->metadata ?? null);

        return view('student.learn', compact(
            'course',
            'activeLesson',
            'flatLessons',
            'totalLessons',
            'currentIndex',
            'prevLesson',
            'nextLesson',
            'youtubeId',
        ));
    }

    private function extractYouTubeVideoId(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
            '/^[a-zA-Z0-9_-]{11}$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
