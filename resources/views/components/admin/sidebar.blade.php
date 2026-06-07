@props(['active' => null, 'actionLabel' => null, 'actionIcon' => null])

@php
    $navItems = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard')],
        ['key' => 'categories', 'label' => 'Master Data', 'icon' => 'database', 'href' => route('categories.index')],
        ['key' => 'users', 'label' => 'Users', 'icon' => 'group', 'href' => route('users.index')],
        ['key' => 'courses', 'label' => 'Courses', 'icon' => 'school', 'href' => '#'],
        ['key' => 'settings', 'label' => 'Settings', 'icon' => 'settings', 'href' => '#'],
    ];
@endphp

<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col border-r border-outline-variant bg-surface p-base lg:flex">
    <div class="px-4 py-6">
        <h1 class="font-headline-md text-headline-md font-bold text-primary">{{ config('app.name', 'EduMentor') }}</h1>
        <p class="font-label-md text-label-md text-on-surface-variant">Admin Console</p>
    </div>

    <nav class="custom-scrollbar mt-4 flex-1 space-y-1 overflow-y-auto px-2">
        @foreach ($navItems as $item)
            <a class="flex items-center gap-3 rounded-lg px-4 py-3 font-label-md text-label-md transition-colors {{ $active === $item['key'] ? 'bg-surface-container-high font-bold text-primary' : 'text-on-surface-variant hover:bg-surface-container-low' }}" href="{{ $item['href'] }}">
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="mt-auto p-4">
        @if ($actionLabel)
            <button class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 font-label-md text-label-md text-on-primary transition-all hover:opacity-90 active:scale-95" type="button">
                @if ($actionIcon)
                    <span class="material-symbols-outlined">{{ $actionIcon }}</span>
                @endif
                {{ $actionLabel }}
            </button>
        @endif
        <div class="mt-6 flex items-center gap-3 border-t border-outline-variant pt-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant bg-primary-fixed font-bold text-primary">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate font-label-md text-label-md font-bold">{{ auth()->user()->name }}</p>
                <p class="truncate text-[12px] text-on-surface-variant">Administrator</p>
            </div>
        </div>
    </div>
</aside>
