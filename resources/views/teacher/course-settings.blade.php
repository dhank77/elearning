@extends('layouts.app')

@section('title', 'Clarity Learning - Course Management')
@section('bodyClass', 'min-h-screen overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@section('body')
    @php
        $lessonIcons = [
            'video' => ['icon' => 'play_circle', 'color' => 'text-secondary'],
            'document' => ['icon' => 'description', 'color' => 'text-primary'],
            'quiz' => ['icon' => 'quiz', 'color' => 'text-tertiary'],
        ];
    @endphp

    <aside class="fixed left-0 top-0 z-50 hidden h-screen w-80 flex-col border-r border-outline-variant/20 bg-surface-container-lowest px-5 py-8 lg:flex">
        <div class="px-2">
            <h1 class="font-headline-lg text-[30px] font-bold leading-9 text-primary">Clarity Learning</h1>
            <p class="mt-1 text-body-md text-on-surface-variant">Instructor Portal</p>
        </div>

        <nav class="mt-16 flex flex-1 flex-col gap-5">
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-[28px]">dashboard</span>
                <span class="text-body-lg">Dashboard</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg border-r-4 border-primary bg-surface-container-low px-5 py-3 font-bold text-primary" href="{{ route('teacher.course-settings') }}">
                <span class="material-symbols-outlined text-[28px]">school</span>
                <span class="text-body-lg">My Courses</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                <span class="material-symbols-outlined text-[28px]">group</span>
                <span class="text-body-lg">Students</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                <span class="material-symbols-outlined text-[28px]">assignment</span>
                <span class="text-body-lg">Assignments</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                <span class="material-symbols-outlined text-[28px]">analytics</span>
                <span class="text-body-lg">Analytics</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                <span class="material-symbols-outlined text-[28px]">settings</span>
                <span class="text-body-lg">Settings</span>
            </a>
        </nav>

        <form method="POST" action="{{ route('teacher.course-settings.store') }}">
            @csrf
            <button class="mb-2 flex w-full items-center justify-center gap-3 rounded-xl bg-primary px-6 py-4 text-body-lg font-semibold text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5 hover:shadow-xl" type="submit">
                <span class="material-symbols-outlined text-[28px]">add</span>
                Create New Course
            </button>
        </form>
    </aside>

    <header class="fixed left-0 right-0 top-0 z-40 flex h-24 items-center bg-background px-margin-mobile lg:left-80 lg:px-10">
        <a class="font-headline-md text-headline-md text-primary lg:hidden" href="{{ route('dashboard') }}">Clarity Learning</a>

        <form class="hidden h-16 w-[480px] items-center gap-4 rounded-full bg-surface-container-low px-6 md:flex" method="GET" action="{{ route('teacher.course-settings') }}">
            <span class="material-symbols-outlined text-[30px] text-on-surface-variant">search</span>
            <input class="w-full border-none bg-transparent text-body-md text-on-surface placeholder:text-on-surface-variant/80 focus:ring-0" name="search" placeholder="Search courses or lessons..." type="search" value="{{ $search }}">
        </form>

        <div class="ml-auto flex items-center gap-6">
            <button class="relative text-on-surface transition-colors hover:text-primary" type="button" aria-label="Notifications">
                <span class="material-symbols-outlined text-[30px]">notifications</span>
                <span class="absolute right-0 top-1 h-2.5 w-2.5 rounded-full bg-error ring-2 ring-background"></span>
            </button>
            <button class="text-on-surface transition-colors hover:text-primary" type="button" aria-label="Help">
                <span class="material-symbols-outlined text-[30px]">help</span>
            </button>
            <details class="group relative">
                <summary class="flex cursor-pointer list-none items-center rounded-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:ring-offset-2 focus:ring-offset-background [&::-webkit-details-marker]:hidden" aria-label="Open account menu">
                    <span class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-full border border-outline-variant bg-secondary-container font-bold text-secondary">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </summary>

                <div class="absolute right-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest py-2 shadow-lg shadow-on-surface/5">
                    <div class="border-b border-outline-variant px-4 py-3">
                        <p class="truncate font-label-md text-label-md font-bold text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="truncate text-[12px] text-on-surface-variant">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary">
                        <span class="material-symbols-outlined text-[20px]">account_circle</span>
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center gap-3 px-4 py-3 text-left font-label-md text-label-md text-error transition-colors hover:bg-error-container/30" type="submit">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </header>

    <main class="min-h-screen pt-24 lg:pl-80">
        <div class="mx-auto max-w-[1200px] px-margin-mobile pb-40 md:px-10">
            <section class="flex flex-col gap-6 pt-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-[40px] font-bold leading-[48px] text-on-surface">Course Management</h2>
                    <p class="mt-1 text-body-lg text-on-surface-variant">Design and refine your learning journeys.</p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row">
                    @if ($activeCourse)
                        <form method="POST" action="{{ route('teacher.course-settings.draft', $activeCourse) }}">
                            @csrf
                            @method('PATCH')
                            <button class="w-full rounded-full border border-outline px-8 py-3.5 text-body-lg font-medium text-on-surface transition-colors hover:bg-surface-container" type="submit">Save as Draft</button>
                        </form>
                        <form method="POST" action="{{ route('teacher.course-settings.publish', $activeCourse) }}">
                            @csrf
                            @method('PATCH')
                            <button class="w-full rounded-full bg-primary px-8 py-3.5 text-body-lg font-medium text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" type="submit">Publish Course</button>
                        </form>
                    @else
                        <button class="rounded-full border border-outline px-8 py-3.5 text-body-lg font-medium text-outline" type="button" disabled>Save as Draft</button>
                        <button class="rounded-full bg-outline-variant px-8 py-3.5 text-body-lg font-medium text-on-surface-variant" type="button" disabled>Publish Course</button>
                    @endif
                </div>
            </section>

            <section class="mt-10 grid grid-cols-1 gap-gutter xl:grid-cols-[380px_minmax(0,1fr)]">
                <aside class="min-w-0">
                    <h3 class="px-1 text-headline-md font-bold text-on-surface sm:text-[30px] sm:leading-9">Your Curriculum</h3>

                    <div class="mt-6 space-y-5">
                        @forelse ($courses as $course)
                            @php
                                $lessonCount = $course->modules->sum(fn ($module) => $module->lessons->count());
                                $isActive = $activeCourse?->is($course);
                            @endphp

                            <a class="{{ $isActive ? 'relative block w-full overflow-hidden rounded-xl border-2 border-primary bg-surface-container-lowest p-5 shadow-sm' : 'block w-full rounded-xl border border-outline-variant bg-surface-container-lowest p-5 transition-colors hover:border-primary' }}" href="{{ route('teacher.course-settings', array_filter(['course' => $course->id, 'search' => $search])) }}">
                                @if ($isActive)
                                    <div class="absolute left-0 top-0 h-full w-1.5 bg-primary"></div>
                                @endif

                                <div class="mb-4 flex items-center justify-between gap-4">
                                    @if ($isActive)
                                        <span class="rounded bg-primary-fixed px-3 py-1 text-[12px] font-bold uppercase tracking-wide text-on-primary-fixed">Active Editing</span>
                                    @else
                                        <span class="{{ $course->status === 'published' ? 'bg-secondary-fixed-dim text-on-secondary-fixed' : 'bg-surface-container text-on-surface' }} rounded px-3 py-1 text-[12px] font-bold uppercase">{{ $course->status }}</span>
                                    @endif
                                    <span class="{{ $isActive ? 'text-primary' : 'text-outline' }} material-symbols-outlined text-[22px]">more_vert</span>
                                </div>

                                <h4 class="{{ $isActive ? 'text-primary' : 'text-on-surface' }} break-words text-body-lg font-semibold sm:text-[22px] sm:leading-7">{{ $course->title }}</h4>
                                <p class="mt-2 text-body-md text-on-surface">{{ $course->modules->count() }} Modules &bull; {{ $lessonCount }} Lessons</p>

                                @if ($isActive)
                                    <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                                        <div class="h-2 flex-1 overflow-hidden rounded-full bg-surface-container-high">
                                            <div class="h-full rounded-full bg-secondary" style="width: {{ $course->completion_percentage }}%"></div>
                                        </div>
                                        <span class="shrink-0 text-label-md font-bold text-secondary">{{ $course->completion_percentage }}% Complete</span>
                                    </div>
                                @else
                                    <div class="mt-5 flex items-center gap-4">
                                        <span class="text-label-md text-on-surface-variant">Modified {{ $course->updated_at->diffForHumans() }}</span>
                                    </div>
                                @endif
                            </a>
                        @empty
                            <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 text-body-md text-on-surface-variant">
                                No courses found. Create your first course to start building.
                            </div>
                        @endforelse

                        <form method="POST" action="{{ route('teacher.course-settings.store') }}">
                            @csrf
                            <button class="flex h-28 w-full flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-outline-variant text-on-surface-variant transition-colors hover:border-primary hover:text-primary" type="submit">
                                <span class="material-symbols-outlined text-[30px]">add_circle</span>
                                <span class="text-body-lg">Add Another Course</span>
                            </button>
                        </form>
                    </div>
                </aside>

                <section class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="grid grid-cols-4 border-b border-outline-variant text-center">
                        <button class="border-b-2 border-primary px-4 py-5 text-body-md font-bold text-primary" type="button">Curriculum</button>
                        <button class="px-4 py-5 text-body-md text-on-surface transition-colors hover:text-primary" type="button">Course Settings</button>
                        <button class="px-4 py-5 text-body-md text-on-surface transition-colors hover:text-primary" type="button">Pricing & Coupons</button>
                        <button class="px-4 py-5 text-body-md text-on-surface transition-colors hover:text-primary" type="button">Students List</button>
                    </div>

                    @if ($activeCourse)
                        <div class="p-8">
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <h3 class="text-[30px] font-bold leading-9 text-on-surface">{{ $activeCourse->title }}</h3>
                                <form method="POST" action="{{ route('teacher.course-settings.modules.store', $activeCourse) }}">
                                    @csrf
                                    <button class="inline-flex items-center justify-center gap-3 rounded-full bg-primary-fixed px-6 py-3 text-body-lg font-medium text-primary transition-colors hover:bg-primary-fixed-dim" type="submit">
                                        <span class="material-symbols-outlined text-[22px]">add</span>
                                        Add Module
                                    </button>
                                </form>
                            </div>

                            <div class="mt-7 space-y-5">
                                @forelse ($activeCourse->modules as $module)
                                    @if ($loop->first)
                                        <article class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest">
                                            <div class="flex items-center gap-5 border-b border-outline-variant bg-surface-container-low px-6 py-5">
                                                <span class="material-symbols-outlined cursor-grab text-[28px] text-outline">drag_indicator</span>
                                                <h4 class="min-w-0 flex-1 text-body-lg font-bold text-on-surface">{{ $module->title }}</h4>
                                                <div class="flex items-center gap-5 text-outline">
                                                    <button class="transition-colors hover:text-primary" type="button" aria-label="Edit module">
                                                        <span class="material-symbols-outlined text-[28px]">edit</span>
                                                    </button>
                                                    <form method="POST" action="{{ route('teacher.course-settings.modules.destroy', $module) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="transition-colors hover:text-error" type="submit" aria-label="Delete module">
                                                            <span class="material-symbols-outlined text-[28px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="space-y-1 px-6 py-4">
                                                @forelse ($module->lessons as $lesson)
                                                    @php
                                                        $lessonStyle = $lessonIcons[$lesson->content_type] ?? $lessonIcons['document'];
                                                    @endphp

                                                    <div class="group flex items-center gap-5 rounded-lg px-2 py-3">
                                                        <span class="{{ $lessonStyle['color'] }} material-symbols-outlined text-[30px]">{{ $lessonStyle['icon'] }}</span>
                                                        <span class="min-w-0 flex-1 text-body-md font-medium text-on-surface">{{ $lesson->title }}</span>
                                                        <span class="text-label-md text-on-surface-variant">{{ $lesson->metadata }}</span>
                                                        <form class="hidden group-hover:block" method="POST" action="{{ route('teacher.course-settings.lessons.destroy', $lesson) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="text-label-md font-bold text-error" type="submit">Remove</button>
                                                        </form>
                                                    </div>
                                                @empty
                                                    <p class="rounded-lg bg-surface-container-low px-4 py-3 text-label-md text-on-surface-variant">No content yet.</p>
                                                @endforelse

                                                <form method="POST" action="{{ route('teacher.course-settings.lessons.store', $module) }}">
                                                    @csrf
                                                    <button class="mt-3 flex w-full items-center justify-center gap-3 rounded-lg border border-dashed border-outline-variant py-3 text-body-md text-on-surface-variant transition-colors hover:border-primary hover:text-primary" type="submit">
                                                        <span class="material-symbols-outlined text-[20px]">add</span>
                                                        Add Content
                                                    </button>
                                                </form>
                                            </div>
                                        </article>
                                    @else
                                        <article class="flex items-center gap-5 rounded-xl border border-outline-variant bg-surface-container-lowest px-6 py-5">
                                            <span class="material-symbols-outlined cursor-grab text-[28px] text-outline">drag_indicator</span>
                                            <h4 class="min-w-0 flex-1 text-body-lg font-bold text-on-surface">{{ $module->title }}</h4>
                                            <span class="text-label-md text-on-surface-variant">{{ $module->lessons->count() }} Lessons</span>
                                            <form method="POST" action="{{ route('teacher.course-settings.modules.destroy', $module) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-outline transition-colors hover:text-error" type="submit" aria-label="Delete module">
                                                    <span class="material-symbols-outlined text-[28px]">delete</span>
                                                </button>
                                            </form>
                                            <span class="material-symbols-outlined text-[28px] text-outline">expand_more</span>
                                        </article>
                                    @endif
                                @empty
                                    <div class="rounded-xl border border-dashed border-outline-variant bg-surface-container-low p-8 text-center">
                                        <p class="text-body-lg font-bold text-on-surface">No modules yet</p>
                                        <p class="mt-2 text-body-md text-on-surface-variant">Add a module or generate one to start the curriculum.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 border-t border-outline-variant px-8 py-7 md:flex-row md:items-center md:justify-between">
                            <p class="text-label-md italic text-on-surface">
                                Last saved {{ $activeCourse->last_saved_at?->diffForHumans() ?? $activeCourse->updated_at->diffForHumans() }}
                            </p>
                            <div class="flex flex-col gap-5 sm:flex-row">
                                <a class="rounded-full border border-primary px-8 py-3 text-center text-body-md font-bold text-primary transition-colors hover:bg-primary-fixed" href="{{ route('teacher.course-settings', ['course' => $activeCourse, 'preview' => true]) }}">Preview Course</a>
                                <form method="POST" action="{{ route('teacher.course-settings.modules.generate', $activeCourse) }}">
                                    @csrf
                                    <button class="w-full rounded-full bg-primary px-9 py-3 text-body-md font-bold text-on-primary shadow-lg shadow-on-surface/10 transition-all hover:-translate-y-0.5" type="submit">Auto-Generate Module</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <p class="text-[30px] font-bold text-on-surface">No course selected</p>
                            <p class="mt-2 text-body-md text-on-surface-variant">Create a course or clear your search to continue.</p>
                        </div>
                    @endif
                </section>
            </section>
        </div>
    </main>

    @if (session('success'))
        <div class="fixed bottom-6 right-10 hidden items-center gap-4 rounded-xl bg-inverse-surface px-8 py-5 text-inverse-on-surface shadow-2xl md:flex">
            <span class="material-symbols-outlined text-[30px] text-secondary-fixed">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif
@endsection
