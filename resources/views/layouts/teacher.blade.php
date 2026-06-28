@extends('layouts.app')

@section('bodyClass', 'bg-background font-body-md text-on-background antialiased')

@section('body')
    <!-- Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed left-0 top-0 z-50 flex h-screen w-64 -translate-x-full flex-col bg-surface-container-lowest px-4 py-6 shadow-sm transition-transform duration-300 lg:translate-x-0 lg:flex">
        <div class="mb-10 px-2">
            <h1 class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</h1>
            <p class="font-body-md text-body-md text-on-surface-variant opacity-70">Instructor Portal</p>
        </div>

        <nav class="flex-1 space-y-2">
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'border-r-4 border-primary bg-surface-container-low font-bold text-primary active:scale-[0.98]' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 transition-all duration-200 {{ request()->routeIs('teacher.course-settings*') ? 'border-r-4 border-primary bg-surface-container-low font-bold text-primary active:scale-[0.98]' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('teacher.course-settings') }}">
                <span class="material-symbols-outlined">school</span>
                <span class="font-body-md text-body-md">My Courses</span>
            </a>
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 transition-all duration-200 {{ request()->routeIs('teacher.coupons*') ? 'border-r-4 border-primary bg-surface-container-low font-bold text-primary active:scale-[0.98]' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('teacher.coupons.index') }}">
                <span class="material-symbols-outlined">sell</span>
                <span class="font-body-md text-body-md">Kupon</span>
            </a>
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 transition-all duration-200 {{ request()->routeIs('teacher.students*') ? 'border-r-4 border-primary bg-surface-container-low font-bold text-primary active:scale-[0.98]' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('teacher.students') }}">
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
            <form method="POST" action="{{ route('teacher.course-settings.store') }}">
                @csrf
                <button class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 font-label-md text-label-md text-on-primary shadow-lg shadow-primary/20 transition-all hover:opacity-90 active:scale-[0.98]" type="submit">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Create New Course
                </button>
            </form>
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

    <!-- Header -->
    <header class="fixed left-0 right-0 top-0 z-40 flex h-16 items-center justify-between bg-surface px-margin-mobile lg:left-64 lg:px-12">
        <div class="flex items-center gap-2">
            <button id="sidebar-toggle" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-primary lg:hidden" type="button" aria-label="Toggle Menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <a class="font-headline-md text-headline-md text-primary lg:hidden" href="{{ route('dashboard') }}">{{ config('app.name', 'EduMentor') }}</a>
        </div>
        
        <div class="flex-1 md:flex items-center">
            @yield('header_left')
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

    <!-- Main Content -->
    <main class="min-h-screen pt-16 lg:pl-64">
        @yield('content')
    </main>
@endsection
