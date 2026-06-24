@extends('layouts.app')

@section('title', 'Course Management')
@section('bodyClass', 'min-h-screen overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('body')
    @php
        $lessonIcons = [
            'youtube' => ['icon' => 'play_circle', 'color' => 'text-error'],
        ];
        $activeTab = request()->query('tab', 'curriculum');
        $openModuleId = request()->integer('open_module') ?: (int) old('module_id');
    @endphp

    <aside class="fixed left-0 top-0 z-50 hidden h-screen w-80 flex-col border-r border-outline-variant/20 bg-surface-container-lowest px-5 py-8 lg:flex">
        <div class="px-2">
            <h1 class="font-headline-lg text-[30px] font-bold leading-9 text-primary">EduMentor</h1>
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
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="{{ route('teacher.students') }}">
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
        <a class="font-headline-md text-headline-md text-primary lg:hidden" href="{{ route('dashboard') }}">EduMentor</a>

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

                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="grid grid-cols-3 overflow-hidden rounded-t-xl border-b border-outline-variant text-center">
                        @foreach (['curriculum' => 'Curriculum', 'settings' => 'Course Settings', 'pricing' => 'Pricing & Coupons'] as $tabKey => $tabLabel)
                            <button class="tab-btn {{ $activeTab === $tabKey ? 'border-b-2 border-primary font-bold text-primary' : 'text-on-surface' }} px-4 py-5 text-body-md transition-colors hover:text-primary" data-tab="{{ $tabKey }}" type="button">{{ $tabLabel }}</button>
                        @endforeach
                    </div>

                    @if ($activeCourse)
                        <div class="tab-panel {{ $activeTab === 'curriculum' ? '' : 'hidden' }}" data-tab-panel="curriculum">
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
                                        <details id="module-{{ $module->id }}" class="group scroll-mt-28 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest" @if ($openModuleId === $module->id || ($openModuleId === 0 && $loop->first)) open @endif>
                                            <summary class="flex cursor-pointer list-none items-center gap-4 bg-surface-container-low px-6 py-5 [&::-webkit-details-marker]:hidden">
                                                <span class="material-symbols-outlined cursor-grab text-[28px] text-outline">drag_indicator</span>
                                                <h4 class="min-w-0 flex-1 text-body-lg font-bold text-on-surface">{{ $module->title }}</h4>
                                                <span class="hidden text-label-md text-on-surface-variant sm:inline">{{ $module->lessons->count() }} Lessons</span>
                                                <span class="material-symbols-outlined text-[28px] text-outline transition-transform group-open:rotate-180">expand_more</span>
                                            </summary>

                                            <div class="border-t border-outline-variant px-6 py-5">
                                                <div class="grid gap-3 rounded-lg bg-surface-container-low p-4 lg:grid-cols-[1fr_auto] lg:items-end">
                                                    <form class="grid gap-3 md:grid-cols-[1fr_auto]" method="POST" action="{{ route('teacher.course-settings.modules.update', $module) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <label class="block">
                                                            <span class="mb-1 block text-label-md font-bold text-on-surface">Module title</span>
                                                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="title" type="text" value="{{ $module->title }}">
                                                        </label>
                                                        <button class="rounded-lg bg-primary px-5 py-2.5 text-label-md font-bold text-on-primary transition-opacity hover:opacity-90" type="submit">Save</button>
                                                    </form>

                                                    <div class="flex gap-2">
                                                        <form method="POST" action="{{ route('teacher.course-settings.modules.move', [$module, 'up']) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg border border-outline-variant p-2 text-outline transition-colors hover:border-primary hover:text-primary" type="submit" aria-label="Move module up">
                                                                <span class="material-symbols-outlined text-[22px]">arrow_upward</span>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('teacher.course-settings.modules.move', [$module, 'down']) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="rounded-lg border border-outline-variant p-2 text-outline transition-colors hover:border-primary hover:text-primary" type="submit" aria-label="Move module down">
                                                                <span class="material-symbols-outlined text-[22px]">arrow_downward</span>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('teacher.course-settings.modules.destroy', $module) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="rounded-lg border border-outline-variant p-2 text-outline transition-colors hover:border-error hover:text-error" type="submit" aria-label="Delete module">
                                                                <span class="material-symbols-outlined text-[22px]">delete</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="mt-5 space-y-4">
                                                    @forelse ($module->lessons as $lesson)
                                                        @php
                                                            $lessonStyle = $lessonIcons['youtube'];
                                                        @endphp

                                                        <div class="rounded-lg border border-outline-variant/70 bg-surface-container-lowest p-4">
                                                            <div class="mb-3 flex min-w-0 items-center gap-4">
                                                                <span class="{{ $lessonStyle['color'] }} material-symbols-outlined text-[28px]">{{ $lessonStyle['icon'] }}</span>
                                                                <span class="min-w-0 flex-1 truncate text-body-md font-bold text-on-surface">{{ $lesson->title }}</span>
                                                                <a class="hidden max-w-48 shrink-0 truncate text-label-md text-primary hover:underline xl:max-w-64 sm:inline" href="{{ $lesson->metadata }}" target="_blank" rel="noopener">YouTube Link</a>
                                                            </div>

                                                            <form class="grid min-w-0 gap-3 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_auto]" method="POST" action="{{ route('teacher.course-settings.lessons.update', $lesson) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input name="module_id" type="hidden" value="{{ $module->id }}">
                                                                <input class="min-w-0 rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-label-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="title" type="text" value="{{ $lesson->title }}" aria-label="Content title">
                                                                <input class="min-w-0 rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-label-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="youtube_url" type="url" value="{{ $lesson->metadata }}" placeholder="https://www.youtube.com/watch?v=..." aria-label="YouTube URL">
                                                                <button class="rounded-lg border border-primary px-4 py-2 text-label-md font-bold text-primary transition-colors hover:bg-primary-fixed" type="submit">Update</button>
                                                            </form>

                                                            <form class="js-confirm-delete mt-3" method="POST" action="{{ route('teacher.course-settings.lessons.destroy', $lesson) }}" data-confirm-title="Hapus konten YouTube?" data-confirm-text="Konten ini akan dihapus permanen dari modul.">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="text-label-md font-bold text-error" type="submit">Hapus Konten</button>
                                                            </form>
                                                        </div>
                                                    @empty
                                                        <p class="rounded-lg bg-surface-container-low px-4 py-3 text-label-md text-on-surface-variant">No content yet.</p>
                                                    @endforelse
                                                </div>

                                                <form class="mt-5 grid gap-3 rounded-lg border border-dashed border-outline-variant p-4 lg:grid-cols-[1fr_1.2fr_auto]" method="POST" action="{{ route('teacher.course-settings.lessons.store', $module) }}">
                                                    @csrf
                                                    <input name="module_id" type="hidden" value="{{ $module->id }}">
                                                    <div>
                                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-label-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="title" type="text" placeholder="New content title" value="{{ (int) old('module_id') === $module->id ? old('title') : '' }}">
                                                        @if ((int) old('module_id') === $module->id)
                                                            @error('title')
                                                                <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                                            @enderror
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-label-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="youtube_url" type="url" placeholder="YouTube URL" value="{{ (int) old('module_id') === $module->id ? old('youtube_url') : '' }}">
                                                        @if ((int) old('module_id') === $module->id)
                                                            @error('youtube_url')
                                                                <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                                            @enderror
                                                        @endif
                                                    </div>
                                                    <button class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-label-md font-bold text-on-primary transition-opacity hover:opacity-90" type="submit">
                                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                                        Add YouTube
                                                    </button>
                                                </form>
                                            </div>
                                        </details>
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
                        </div>

                        <div class="tab-panel {{ $activeTab === 'settings' ? '' : 'hidden' }}" data-tab-panel="settings">
                            <form id="course-settings-form" method="POST" action="{{ route('teacher.course-settings.settings.update', $activeCourse) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="p-8 space-y-8">
                                    <div>
                                        <h3 class="text-[30px] font-bold leading-9 text-on-surface">Course Settings</h3>
                                        <p class="mt-1 text-body-md text-on-surface-variant">Configure the title and description for your course.</p>
                                    </div>

                                    <label class="block">
                                        <span class="mb-2 block text-label-md font-bold text-on-surface">Course Title</span>
                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="title" type="text" value="{{ $activeCourse->title }}">
                                        @error('title')
                                            <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                        @enderror
                                    </label>

                                    <div>
                                        <span class="mb-2 block text-label-md font-bold text-on-surface">Course Description</span>
                                        <div class="relative z-10 [&_.ql-picker-options]:z-50 [&_.ql-toolbar]:relative [&_.ql-toolbar]:z-20">
                                            <div id="quill-editor" class="min-h-[200px] rounded-lg border border-outline-variant bg-surface-container-lowest text-body-md text-on-surface">
                                                {!! $activeCourse->description ?? '' !!}
                                            </div>
                                        </div>
                                        <input id="description-input" name="description" type="hidden">
                                        @error('description')
                                            <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <span class="mb-2 block text-label-md font-bold text-on-surface">Course Cover</span>
                                        <div class="grid gap-4 rounded-lg border border-outline-variant bg-surface-container-low p-4 md:grid-cols-[220px_minmax(0,1fr)] md:items-center">
                                            <div class="aspect-video overflow-hidden rounded-lg border border-outline-variant bg-surface-container-high">
                                                @if ($activeCourse->cover_image_path)
                                                    <img class="h-full w-full object-cover" src="{{ asset('storage/'.$activeCourse->cover_image_path) }}" alt="{{ $activeCourse->title }} cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-on-surface-variant">
                                                        <span class="material-symbols-outlined text-[40px]">image</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <label class="block">
                                                <span class="mb-1 block text-label-md font-medium text-on-surface-variant">Upload JPG, PNG, or WebP up to 2 MB.</span>
                                                <input class="block w-full cursor-pointer rounded-lg border border-outline-variant bg-surface-container-lowest text-label-md text-on-surface file:mr-4 file:border-0 file:bg-primary file:px-4 file:py-2.5 file:text-label-md file:font-bold file:text-on-primary hover:file:opacity-90 focus:border-primary focus:ring-2 focus:ring-primary/20" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp">
                                                @error('cover_image')
                                                    <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                                @enderror
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-end">
                                        <p class="text-label-md italic text-on-surface">
                                            Last saved {{ $activeCourse->last_saved_at?->diffForHumans() ?? $activeCourse->updated_at->diffForHumans() }}
                                        </p>
                                        <button class="rounded-full bg-primary px-9 py-3.5 text-body-lg font-medium text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" type="submit">Save Settings</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-panel {{ $activeTab === 'pricing' ? '' : 'hidden' }}" data-tab-panel="pricing">
                            <form id="course-pricing-form" method="POST" action="{{ route('teacher.course-settings.pricing.update', $activeCourse) }}">
                                @csrf
                                @method('PATCH')

                                <div class="flex flex-col gap-8 rounded-2xl border border-outline-variant bg-surface-container-low p-8 shadow-sm">
                                    <div>
                                        <h3 class="text-headline-sm font-bold text-on-surface">Pricing & Coupons</h3>
                                        <p class="mt-1 text-body-md text-on-surface-variant">Atur harga kursus Anda dan kaitkan kode promo kupon.</p>
                                    </div>

                                    <div class="grid gap-6 md:grid-cols-2">
                                        <label class="block">
                                            <span class="mb-2 block text-label-md font-bold text-on-surface">Harga Kursus (Rp)</span>
                                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="price" type="text" id="price-input" value="{{ old('price', (int) $activeCourse->price) }}">
                                            @error('price')
                                                <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                            @enderror
                                        </label>

                                        <label class="block">
                                            <span class="mb-2 block text-label-md font-bold text-on-surface">Kode Promo / Kupon</span>
                                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20" name="promo_code" type="text" placeholder="Masukkan kode promo" value="{{ old('promo_code', $activeCourse->coupon?->code) }}">
                                            @error('promo_code')
                                                <p class="mt-1 text-label-md text-error">{{ $message }}</p>
                                            @enderror
                                            @if ($activeCourse->coupon)
                                                <p class="mt-1 text-[12px] text-primary">Kupon aktif: diskon {{ (int) $activeCourse->coupon->discount_percentage }}%</p>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-end border-t border-outline-variant/30 pt-6">
                                        <p class="text-label-md italic text-on-surface">
                                            Last saved {{ $activeCourse->last_saved_at?->diffForHumans() ?? $activeCourse->updated_at->diffForHumans() }}
                                        </p>
                                        <button class="rounded-full bg-primary px-9 py-3.5 text-body-lg font-medium text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" type="submit">Save Pricing</button>
                                    </div>
                                </div>
                            </form>
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
        <div class="fixed bottom-6 right-10 hidden items-center gap-4 rounded-xl bg-inverse-surface px-8 py-5 text-inverse-on-surface shadow-2xl md:flex" id="success-toast">
            <span class="material-symbols-outlined text-[30px] text-secondary-fixed">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    const activeTab = '{{ $activeTab }}';
    let quill = null;

    function switchTab(tabKey) {
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('border-b-2', 'border-primary', 'font-bold', 'text-primary');
        });
        const activeBtn = document.querySelector('.tab-btn[data-tab="' + tabKey + '"]');
        if (activeBtn) activeBtn.classList.add('border-b-2', 'border-primary', 'font-bold', 'text-primary');

        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        const activePanel = document.querySelector('[data-tab-panel="' + tabKey + '"]');
        if (activePanel) activePanel.classList.remove('hidden');

        const url = new URL(window.location);
        url.searchParams.set('tab', tabKey);
        window.history.replaceState({}, '', url);

        if (tabKey === 'settings' && !quill) {
            initQuill();
        }
    }

    function initQuill() {
        const editorEl = document.getElementById('quill-editor');
        if (!editorEl) return;

        const existingContent = editorEl.innerHTML;
        editorEl.innerHTML = '';

        quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write your course description here...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ color: [] }, { background: [] }],
                    ['link', 'image'],
                    ['clean'],
                ],
            },
        });

        quill.clipboard.dangerouslyPasteHTML(existingContent);
        updateDescriptionInput();

        const toolbarEl = editorEl.previousElementSibling;
        if (toolbarEl) {
            ['click', 'mousedown'].forEach(eventName => {
                toolbarEl.addEventListener(eventName, function(event) {
                    event.stopPropagation();
                });
            });
        }

        quill.on('text-change', function() {
            updateDescriptionInput();
        });
    }

    function updateDescriptionInput() {
        const descriptionInput = document.getElementById('description-input');
        if (descriptionInput && quill) {
            descriptionInput.value = quill.root.innerHTML;
        }
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchTab(this.dataset.tab);
        });
    });

    if (activeTab === 'settings') {
        initQuill();
    }

    const courseSettingsForm = document.getElementById('course-settings-form');
    if (courseSettingsForm) {
        courseSettingsForm.addEventListener('submit', function() {
            if (!quill) {
                initQuill();
            }

            updateDescriptionInput();
        });
    }

    document.querySelectorAll('.js-confirm-delete').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (this.dataset.swalConfirmed === 'true') {
                return;
            }

            event.preventDefault();

            Swal.fire({
                title: this.dataset.confirmTitle ?? 'Apakah Anda yakin?',
                text: this.dataset.confirmText ?? 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus Konten',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-lg',
                    confirmButton: 'rounded-lg bg-error px-5 py-2.5 text-label-md font-bold text-on-error transition-opacity hover:opacity-90',
                    cancelButton: 'mr-3 rounded-lg border border-outline-variant px-5 py-2.5 text-label-md font-bold text-on-surface transition-colors hover:border-primary hover:text-primary',
                },
            }).then(result => {
                if (result.isConfirmed) {
                    this.dataset.swalConfirmed = 'true';
                    this.submit();
                }
            });
        });
    });

    const successToast = document.getElementById('success-toast');
    if (successToast) {
        setTimeout(() => { successToast.classList.add('hidden'); }, 3000);
    }

    // Format Price input with thousands separators
    const priceInput = document.getElementById('price-input');
    const coursePricingForm = document.getElementById('course-pricing-form');

    function formatRupiah(value) {
        if (!value && value !== 0) return '';
        // Remove all non-digits
        const num = value.toString().replace(/[^0-9]/g, '');
        // Add thousands separator
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    if (priceInput) {
        // Initial format
        priceInput.value = formatRupiah(priceInput.value);

        priceInput.addEventListener('input', function() {
            this.value = formatRupiah(this.value);
        });
    }

    if (coursePricingForm) {
        coursePricingForm.addEventListener('submit', function() {
            if (priceInput) {
                // Strip dots before submitting so it is saved as an integer
                priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
            }
        });
    }
</script>
@endpush
