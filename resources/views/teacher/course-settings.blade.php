@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Course Settings')
@section('bodyClass', 'bg-background font-body-md text-on-background antialiased')

@section('body')
    <aside class="fixed left-0 top-0 z-50 hidden h-screen w-64 flex-col bg-surface-container-lowest px-4 py-6 shadow-sm lg:flex">
        <div class="mb-10 px-2">
            <h1 class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'Laravel') }}</h1>
            <p class="font-body-md text-body-md text-on-surface-variant opacity-70">Instructor Portal</p>
        </div>

        <nav class="flex-1 space-y-2">
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 rounded-lg border-r-4 border-primary bg-surface-container-low px-4 py-3 font-bold text-primary transition-transform duration-200 active:scale-[0.98]" href="{{ route('teacher.course-settings') }}">
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
                    <p class="truncate text-[12px] text-on-surface-variant">Course Mentor</p>
                </div>
            </div>
        </div>
    </aside>

    <header class="fixed left-0 right-0 top-0 z-40 flex h-16 items-center justify-between border-b border-outline-variant/40 bg-surface px-margin-mobile lg:left-64 lg:px-12">
        <a class="font-headline-md text-headline-md text-primary lg:hidden" href="{{ route('dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
        <div class="hidden w-96 items-center rounded-full bg-surface-container px-4 py-2 md:flex">
            <span class="material-symbols-outlined text-on-surface-variant">search</span>
            <input class="w-full border-none bg-transparent font-label-md text-label-md placeholder:text-on-surface-variant/50 focus:ring-0" placeholder="Search courses or lessons..." type="text">
        </div>
        <div class="ml-auto flex items-center gap-5">
            <button class="relative text-on-surface-variant transition-colors hover:text-primary" type="button" aria-label="Notifications">
                <span class="material-symbols-outlined">notifications</span>
                <span class="absolute right-0 top-0 h-2 w-2 rounded-full border-2 border-surface bg-error"></span>
            </button>
            <button class="text-on-surface-variant transition-colors hover:text-primary" type="button" aria-label="Help">
                <span class="material-symbols-outlined">help</span>
            </button>
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
                    <p class="mb-2 inline-flex items-center gap-2 rounded-full bg-secondary-container px-3 py-1 font-label-md text-label-md text-on-secondary-container">
                        <span class="h-2 w-2 rounded-full bg-secondary"></span>
                        Active editing
                    </p>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Course Settings</h2>
                    <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Kelola identitas, akses, dan status publikasi kursus pengajar.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <button class="rounded-full border border-outline px-6 py-2.5 font-label-md text-label-md text-on-surface transition-colors hover:bg-surface-container" type="button">Save as Draft</button>
                    <button class="rounded-full bg-primary px-6 py-2.5 font-label-md text-label-md text-on-primary shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5" type="button">Publish Course</button>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-gutter xl:grid-cols-12">
                <aside class="space-y-4 xl:col-span-4">
                    <div class="flex items-center justify-between gap-4 px-1">
                        <h3 class="font-headline-md text-headline-md text-on-surface">Your Curriculum</h3>
                        <button class="rounded-full border border-outline-variant p-2 text-on-surface-variant transition-colors hover:bg-surface-container hover:text-primary" type="button" aria-label="Add course">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                        </button>
                    </div>

                    <article class="bento-card relative overflow-hidden rounded-xl border-2 border-primary bg-surface-container-lowest p-4 shadow-sm">
                        <div class="absolute left-0 top-0 h-full w-1 bg-primary"></div>
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <span class="rounded-full bg-primary-fixed px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-on-primary-fixed">Editing</span>
                            <button class="text-primary" type="button" aria-label="Course options">
                                <span class="material-symbols-outlined text-[20px]">more_vert</span>
                            </button>
                        </div>
                        <h4 class="font-headline-md text-body-lg font-bold text-primary">Advanced UX Fundamentals</h4>
                        <p class="mt-1 text-label-md text-on-surface-variant">8 Modules • 24 Lessons • 428 Students</p>
                        <div class="mt-4 flex items-center gap-3">
                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-surface-container-high">
                                <div class="h-full rounded-full bg-secondary" style="width: 75%"></div>
                            </div>
                            <span class="text-[12px] font-bold text-secondary">75%</span>
                        </div>
                    </article>

                    <article class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-4">
                        <h4 class="font-body-lg font-semibold text-on-surface">Introduction to Python</h4>
                        <p class="mt-1 text-label-md text-on-surface-variant">12 Modules • 48 Lessons</p>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="rounded-full bg-surface-container px-3 py-1 text-[10px] font-bold uppercase text-on-surface-variant">Draft</span>
                            <span class="text-[12px] text-outline">Modified 2 days ago</span>
                        </div>
                    </article>

                    <article class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-4">
                        <h4 class="font-body-lg font-semibold text-on-surface">Digital Marketing 101</h4>
                        <p class="mt-1 text-label-md text-on-surface-variant">6 Modules • 18 Lessons</p>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="rounded-full bg-secondary-container px-3 py-1 text-[10px] font-bold uppercase text-on-secondary-container">Published</span>
                            <span class="text-[12px] text-outline">Modified 1 week ago</span>
                        </div>
                    </article>
                </aside>

                <section class="xl:col-span-8">
                    <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                        <div class="custom-scrollbar flex overflow-x-auto border-b border-outline-variant px-4">
                            <button class="shrink-0 px-4 py-4 font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary" type="button">Curriculum</button>
                            <button class="shrink-0 border-b-2 border-primary px-4 py-4 font-label-md text-label-md font-bold text-primary" type="button">Course Settings</button>
                            <button class="shrink-0 px-4 py-4 font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary" type="button">Pricing & Coupons</button>
                            <button class="shrink-0 px-4 py-4 font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary" type="button">Students List</button>
                        </div>

                        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
                            <form class="space-y-gutter p-6 lg:col-span-8" action="#" method="POST">
                                @csrf
                                <section class="space-y-5">
                                    <div>
                                        <h3 class="font-headline-md text-headline-md text-on-surface">Course Identity</h3>
                                        <p class="mt-1 text-label-md text-on-surface-variant">Informasi utama yang muncul di katalog dan halaman detail kursus.</p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="course_title">Course Title</label>
                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="course_title" name="course_title" type="text" value="Advanced UX Fundamentals">
                                    </div>

                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="course_subtitle">Subtitle</label>
                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="course_subtitle" name="course_subtitle" type="text" value="Build research-backed interfaces that reduce cognitive load.">
                                    </div>

                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="description">Description</label>
                                        <textarea class="min-h-36 w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="description" name="description">Kursus ini membantu siswa memahami prinsip UX modern, riset pengguna, dan prototyping dengan pendekatan studi kasus.</textarea>
                                    </div>
                                </section>

                                <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="level">Level</label>
                                        <select class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="level" name="level">
                                            <option>Beginner</option>
                                            <option selected>Intermediate</option>
                                            <option>Advanced</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="category">Category</label>
                                        <select class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="category" name="category">
                                            <option selected>Design</option>
                                            <option>Development</option>
                                            <option>Marketing</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="language">Language</label>
                                        <select class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="language" name="language">
                                            <option selected>Indonesia</option>
                                            <option>English</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block font-label-md text-label-md text-on-surface" for="duration">Estimated Duration</label>
                                        <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-surface transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" id="duration" name="duration" type="text" value="8 weeks">
                                    </div>
                                </section>

                                <section class="space-y-4 rounded-xl border border-outline-variant bg-surface-container-low p-5">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <h3 class="font-body-lg font-bold text-on-surface">Visibility</h3>
                                            <p class="mt-1 text-label-md text-on-surface-variant">Status ini menentukan apakah kursus tampil di katalog siswa.</p>
                                        </div>
                                        <label class="inline-flex cursor-pointer items-center gap-3">
                                            <input class="peer sr-only" type="checkbox" checked>
                                            <span class="relative h-7 w-12 rounded-full bg-outline-variant transition-colors after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-on-primary after:shadow-sm after:transition-transform peer-checked:bg-secondary peer-checked:after:translate-x-5"></span>
                                            <span class="font-label-md text-label-md text-secondary">Published</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <span class="rounded-lg bg-surface-container-lowest px-4 py-3 text-label-md text-on-surface-variant"><strong class="text-on-surface">428</strong> students</span>
                                        <span class="rounded-lg bg-surface-container-lowest px-4 py-3 text-label-md text-on-surface-variant"><strong class="text-on-surface">4.8</strong> rating</span>
                                        <span class="rounded-lg bg-surface-container-lowest px-4 py-3 text-label-md text-on-surface-variant"><strong class="text-on-surface">24</strong> lessons</span>
                                    </div>
                                </section>

                                <div class="flex flex-col-reverse gap-3 border-t border-outline-variant pt-6 sm:flex-row sm:justify-end">
                                    <button class="rounded-full border border-primary px-6 py-2.5 font-label-md text-label-md font-bold text-primary transition-colors hover:bg-primary-fixed" type="button">Preview Course</button>
                                    <button class="rounded-full bg-primary px-8 py-2.5 font-label-md text-label-md font-bold text-on-primary shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5" type="submit">Save Settings</button>
                                </div>
                            </form>

                            <aside class="space-y-gutter border-t border-outline-variant bg-surface-container-low p-6 lg:col-span-4 lg:border-l lg:border-t-0">
                                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5">
                                    <div class="mb-4 flex items-center justify-between gap-4">
                                        <h3 class="font-body-lg font-bold text-on-surface">Cover Preview</h3>
                                        <span class="rounded-full bg-tertiary-fixed px-3 py-1 text-[12px] font-bold text-on-tertiary-fixed">Featured</span>
                                    </div>
                                    <div class="overflow-hidden rounded-lg bg-surface-container-high">
                                        <img class="h-44 w-full object-cover" src="https://images.unsplash.com/photo-1559028012-481c04fa702d?auto=format&fit=crop&w=900&q=80" alt="Advanced UX course cover">
                                    </div>
                                    <button class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg border border-dashed border-outline-variant px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:border-primary hover:text-primary" type="button">
                                        <span class="material-symbols-outlined text-[20px]">upload</span>
                                        Replace Cover
                                    </button>
                                </section>

                                <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5">
                                    <h3 class="font-body-lg font-bold text-on-surface">Publish Checklist</h3>
                                    <div class="mt-4 space-y-3">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <span class="text-label-md text-on-surface">Course identity complete</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <span class="text-label-md text-on-surface">Cover image uploaded</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">error</span>
                                            <span class="text-label-md text-on-surface">Pricing needs review</span>
                                        </div>
                                    </div>
                                </section>

                                <section class="rounded-xl bg-inverse-surface p-5 text-inverse-on-surface">
                                    <p class="font-label-md text-label-md opacity-80">Last saved</p>
                                    <p class="mt-1 font-body-lg text-body-lg font-bold">10:45 AM today</p>
                                    <p class="mt-3 text-label-md text-inverse-on-surface/80">Draft reviewed by curriculum operations.</p>
                                </section>
                            </aside>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </main>
@endsection
