@props(['active' => null])

@php
    $navItems = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard'), 'filled' => true],
        ['key' => 'courses', 'label' => 'All Courses', 'icon' => 'school', 'href' => '#'],
        ['key' => 'assignments', 'label' => 'Assignments', 'icon' => 'assignment', 'href' => '#'],
        ['key' => 'grades', 'label' => 'Grades', 'icon' => 'grade', 'href' => '#'],
        ['key' => 'profile', 'label' => 'Profile', 'icon' => 'person', 'href' => route('profile.edit')],
    ];
@endphp

<aside class="sticky top-16 hidden h-[calc(100vh-64px)] w-64 flex-col gap-2 border-r border-outline-variant bg-surface p-4 lg:flex">
    <div class="mb-6 px-2">
        <h2 class="font-headline-md text-headline-md text-primary">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-label-md text-on-surface-variant">Continue your React course</p>
    </div>

    <nav class="flex flex-col gap-1">
        @foreach ($navItems as $item)
            <a class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all {{ $active === $item['key'] ? 'scale-95 bg-primary-container font-bold text-on-primary-container duration-150' : 'text-on-surface-variant hover:bg-surface-container-high' }}" href="{{ $item['href'] }}">
                <span class="material-symbols-outlined" @if (($item['filled'] ?? false) && $active === $item['key']) style="font-variation-settings: 'FILL' 1;" @endif>{{ $item['icon'] }}</span>
                <span class="font-label-md text-label-md">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto flex flex-col gap-2 rounded-2xl bg-secondary-container p-4 text-on-secondary-container">
        <p class="font-bold text-label-md">Unlock Full Access</p>
        <p class="text-[12px] opacity-90">Get certificates and career coaching.</p>
        <button class="mt-2 rounded-lg bg-on-secondary-container px-4 py-2 text-label-md font-bold text-on-secondary transition-opacity hover:opacity-90" type="button">
            Upgrade to Pro
        </button>
    </div>
</aside>
