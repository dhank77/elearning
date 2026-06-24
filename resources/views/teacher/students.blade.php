@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Students List')
@section('bodyClass', 'min-h-screen overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@section('body')
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
            <a class="flex items-center gap-4 rounded-lg px-5 py-3 text-[22px] text-on-surface-variant transition-colors hover:bg-surface-container" href="{{ route('teacher.course-settings') }}">
                <span class="material-symbols-outlined text-[28px]">school</span>
                <span class="text-body-lg">My Courses</span>
            </a>
            <a class="flex items-center gap-4 rounded-lg border-r-4 border-primary bg-surface-container-low px-5 py-3 font-bold text-primary" href="{{ route('teacher.students') }}">
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
                    <h2 class="text-[40px] font-bold leading-[48px] text-on-surface">Students</h2>
                    <p class="mt-1 text-body-lg text-on-surface-variant">View and manage your student enrollments.</p>
                </div>
            </section>

            <section class="mt-10 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                @if($students->isEmpty())
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-[64px] text-on-surface-variant opacity-50">group</span>
                        <p class="mt-4 text-[30px] font-bold text-on-surface">No Students Enrolled</p>
                        <p class="mt-2 text-body-md text-on-surface-variant">When students purchase or enroll in your courses, they will appear here.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-outline-variant bg-surface-container-low/55">
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Student</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Email</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Phone</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Enrolled Courses</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Joined Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/30">
                                @foreach($students as $student)
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-secondary-container font-bold text-secondary">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="font-semibold text-on-surface">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            {{ $student->phone ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($student->courseOrders as $order)
                                                    @if($order->course)
                                                        <span class="inline-flex items-center rounded-md bg-primary-container px-2.5 py-1 text-xs font-medium text-on-primary-container">
                                                            {{ $order->course->title }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            @php
                                                $firstOrder = $student->courseOrders->first();
                                                $joinedDate = $firstOrder ? $firstOrder->paid_at?->format('d M Y') ?? $firstOrder->created_at->format('d M Y') : $student->created_at->format('d M Y');
                                            @endphp
                                            {{ $joinedDate }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection
