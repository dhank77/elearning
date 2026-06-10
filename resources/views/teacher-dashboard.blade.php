@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Teacher Dashboard')
@section('bodyClass', 'bg-background font-body-md text-on-background antialiased')

@section('body')
    @php
        $defaultCourseCover = 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80';
    @endphp

        <aside class="fixed left-0 top-0 z-50 hidden h-screen w-64 flex-col bg-surface-container-lowest px-4 py-6 shadow-sm lg:flex">
            <div class="mb-10 px-2">
                <h1 class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'Laravel') }}</h1>
                <p class="font-body-md text-body-md text-on-surface-variant opacity-70">Instructor Portal</p>
            </div>

            <nav class="flex-1 space-y-2">
                <a class="flex items-center gap-3 rounded-lg border-r-4 border-primary bg-surface-container-low px-4 py-3 font-bold text-primary transition-transform duration-200 active:scale-[0.98]" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-body-md text-body-md">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container" href="{{ route('teacher.course-settings') }}">
                    <span class="material-symbols-outlined">school</span>
                    <span class="font-body-md text-body-md">My Courses</span>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                    <span class="material-symbols-outlined">group</span>
                    <span class="font-body-md text-body-md">Students</span>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                    <span class="material-symbols-outlined">assignment</span>
                    <span class="font-body-md text-body-md">Assignments</span>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container" href="#">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-body-md text-body-md">Analytics</span>
                </a>
            </nav>

            <div class="mt-auto px-2">
                <button class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 font-label-md text-label-md text-on-primary shadow-lg shadow-primary/20 transition-all hover:opacity-90" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Create New Course
                </button>
                <div class="mt-6 flex items-center gap-3 rounded-lg bg-surface-container-low p-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-primary-fixed bg-secondary-container font-bold text-secondary">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate font-label-md text-label-md text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="truncate text-[12px] text-on-surface-variant">Senior Mentor</p>
                    </div>
                </div>
            </div>
        </aside>

        <header class="fixed left-0 right-0 top-0 z-40 flex h-16 items-center justify-between bg-surface px-margin-mobile lg:left-64 lg:px-12">
            <div class="hidden w-96 items-center rounded-full bg-surface-container px-4 py-2 md:flex">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input class="w-full border-none bg-transparent font-label-md text-label-md placeholder:text-on-surface-variant/50 focus:ring-0" placeholder="Search students, courses, or files..." type="text">
            </div>
            <div class="ml-auto flex items-center gap-6">
                <div class="flex items-center gap-4 border-r border-outline-variant pr-6">
                    <button class="relative text-on-surface-variant transition-colors hover:text-primary" type="button" aria-label="Notifications">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute right-0 top-0 h-2 w-2 rounded-full border-2 border-surface bg-error"></span>
                    </button>
                    <button class="text-on-surface-variant transition-colors hover:text-primary" type="button" aria-label="Help">
                        <span class="material-symbols-outlined">help</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-on-surface-variant transition-colors hover:text-primary" type="submit" aria-label="Log out">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="min-h-screen pt-16 lg:pl-64">
            <div class="mx-auto max-w-[1280px] space-y-gutter p-margin-mobile md:p-gutter">
                <section class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Selamat Datang, {{ auth()->user()->name }}</h2>
                        <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Anda memiliki {{ $pendingAssignmentsCount }} tugas baru yang perlu dinilai hari ini. Mari beri inspirasi bagi siswa Anda.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button class="rounded-full border border-secondary px-6 py-2.5 font-label-md text-label-md text-secondary transition-colors hover:bg-secondary-container" type="button">Download Syllabus</button>
                        <button class="rounded-full bg-primary px-6 py-2.5 font-label-md text-label-md text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" type="button">Review Schedule</button>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-gutter sm:grid-cols-2 lg:grid-cols-4">
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-6 shadow-sm transition-colors hover:border-primary">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-container text-on-primary-container"><span class="material-symbols-outlined">group</span></div>
                        <div><p class="font-label-md text-label-md text-on-surface-variant">Total Siswa</p><h3 class="font-headline-md text-headline-md text-on-surface">{{ $totalStudentsCount }}</h3></div>
                    </div>
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-6 shadow-sm transition-colors hover:border-primary">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container"><span class="material-symbols-outlined">school</span></div>
                        <div><p class="font-label-md text-label-md text-on-surface-variant">Kursus Aktif</p><h3 class="font-headline-md text-headline-md text-on-surface">{{ $activeCoursesCount }}</h3></div>
                    </div>
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-6 shadow-sm transition-colors hover:border-primary">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-tertiary-fixed text-on-tertiary-fixed"><span class="material-symbols-outlined">view_module</span></div>
                        <div><p class="font-label-md text-label-md text-on-surface-variant">Total Kursus</p><h3 class="font-headline-md text-headline-md text-on-surface">{{ $courses->count() }}</h3></div>
                    </div>
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-6 shadow-sm transition-colors hover:border-primary">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-error-container text-on-error-container"><span class="material-symbols-outlined">pending_actions</span></div>
                        <div><p class="font-label-md text-label-md text-on-surface-variant">Tugas Perlu Dinilai</p><h3 class="font-headline-md text-headline-md text-on-surface">{{ $pendingAssignmentsCount }}</h3></div>
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-gutter lg:grid-cols-12">
                    <section class="space-y-gutter lg:col-span-8">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Active Courses</h3>
                            <a class="font-label-md text-label-md text-primary hover:underline" href="{{ route('teacher.course-settings') }}">View All Courses</a>
                        </div>
                        <div class="grid grid-cols-1 gap-gutter md:grid-cols-2">
                            @forelse($courses as $course)
                            @php
                                $courseCover = $course->cover_image_path ? asset('storage/'.$course->cover_image_path) : $defaultCourseCover;
                            @endphp
                            <article class="group overflow-hidden rounded-2xl border border-outline-variant/50 bg-surface-container-lowest transition-all duration-300 hover:shadow-xl">
                                <div class="relative h-40 overflow-hidden bg-surface-container-high">
                                    <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $course->title }}" src="{{ $courseCover }}">
                                    <span class="absolute left-4 top-4 flex items-center gap-1 rounded-full bg-surface-container-lowest/90 px-3 py-1 text-[12px] font-bold text-primary"><span class="h-2 w-2 rounded-full {{ $course->status === 'published' ? 'bg-secondary' : 'bg-outline' }}"></span>{{ ucfirst($course->status) }}</span>
                                </div>
                                <div class="p-6">
                                    <h4 class="mb-2 font-headline-md text-body-lg font-bold text-on-surface">{{ $course->title }}</h4>
                                    <div class="mb-4 flex items-center gap-4 text-[14px] text-on-surface-variant">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">view_module</span>{{ $course->modules_count }} Modul</span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-[12px] font-bold"><span class="text-on-surface-variant">Course Progress</span><span class="text-primary">{{ $course->completion_percentage }}%</span></div>
                                        <div class="h-2 w-full overflow-hidden rounded-full bg-surface-container"><div class="h-full rounded-full bg-secondary" style="width: {{ $course->completion_percentage }}%"></div></div>
                                    </div>
                                </div>
                            </article>
                            @empty
                            <div class="col-span-full rounded-2xl border border-outline-variant/30 bg-surface-container-lowest p-12 text-center">
                                <span class="material-symbols-outlined text-[48px] text-on-surface-variant">school</span>
                                <p class="mt-4 font-headline-md text-body-lg text-on-surface-variant">Belum ada kursus.</p>
                                <a class="mt-4 inline-block rounded-full bg-primary px-6 py-2.5 font-label-md text-label-md text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" href="{{ route('teacher.course-settings') }}">Buat Kursus Pertama</a>
                            </div>
                            @endforelse
                        </div>
                    </section>

                    <aside class="space-y-gutter lg:col-span-4">
                        <section class="rounded-2xl bg-primary p-6 text-on-primary shadow-xl shadow-primary/20">
                            <h4 class="mb-2 font-headline-md text-body-lg font-bold">Quick Actions</h4>
                            <p class="mb-4 text-[14px] text-on-primary-container opacity-90">Kelola kurikulum dan tugas dengan cepat.</p>
                            <div class="grid grid-cols-2 gap-3">
                                <button class="flex flex-col items-center justify-center gap-2 rounded-xl bg-on-primary/10 p-3 transition-colors hover:bg-on-primary/20" type="button"><span class="material-symbols-outlined">add_circle</span><span class="text-[12px] font-bold">Buat Kursus</span></button>
                                <button class="flex flex-col items-center justify-center gap-2 rounded-xl bg-on-primary/10 p-3 transition-colors hover:bg-on-primary/20" type="button"><span class="material-symbols-outlined">assignment_turned_in</span><span class="text-[12px] font-bold">Nilai Tugas</span></button>
                            </div>
                        </section>

                        <section class="rounded-2xl border border-outline-variant/30 bg-surface-container-lowest p-6 shadow-sm">
                            <div class="mb-6 flex items-center justify-between">
                                <h4 class="font-headline-md text-body-lg font-bold text-on-surface">Kursus Terbaru</h4>
                                <a class="font-label-md text-label-md text-primary hover:underline" href="{{ route('teacher.course-settings') }}">Lihat Semua</a>
                            </div>
                            <div class="custom-scrollbar max-h-[400px] space-y-4 overflow-y-auto pr-2">
                                @forelse($courses as $course)
                                <div class="flex gap-4 rounded-lg border border-outline-variant/30 p-3 transition-colors hover:border-primary">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $course->status === 'published' ? 'bg-secondary-container text-secondary' : 'bg-surface-container-high text-on-surface-variant' }}">
                                        <span class="material-symbols-outlined">{{ $course->status === 'published' ? 'check_circle' : 'edit_note' }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-[14px] font-bold text-on-surface">{{ $course->title }}</p>
                                        <p class="text-[12px] text-on-surface-variant">{{ $course->modules_count }} modul &middot; {{ $course->completion_percentage }}% selesai &middot; {{ ucfirst($course->status) }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-[14px] text-on-surface-variant">Belum ada kursus.</p>
                                @endforelse
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </main>
@endsection
