@props([
    'active' => null,
    'actionLabel' => null,
    'actionIcon' => null,
    'navItems' => null,
    'portalLabel' => null,
    'userRoleLabel' => null,
])

@php
    $role = auth()->user()?->role;
    $portalLabel ??= ($role === 'admin' ? 'Admin Console' : 'Student Portal');
    $userRoleLabel ??= ($role === 'admin' ? 'Administrator' : 'Student');

    if (!isset($navItems)) {
        if ($role === 'admin') {
            $navItems = [
                ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard')],
                ['key' => 'categories', 'label' => 'Kategori', 'icon' => 'database', 'href' => route('categories.index')],
                ['key' => 'coupons', 'label' => 'Kupon', 'icon' => 'sell', 'href' => route('coupons.index')],
                ['key' => 'users', 'label' => 'Users', 'icon' => 'group', 'href' => route('users.index')],
                ['key' => 'courses', 'label' => 'Courses', 'icon' => 'school', 'href' => '#'],
                ['key' => 'settings', 'label' => 'Settings', 'icon' => 'settings', 'href' => '#'],
            ];
        } else {
            $navItems = [
                ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard')],
                ['key' => 'courses', 'label' => 'Kursus Saya', 'icon' => 'school', 'href' => route('student.courses')],
                ['key' => 'learning', 'label' => 'Pembelajaran', 'icon' => 'menu_book', 'href' => '#'],
                ['key' => 'assignments', 'label' => 'Tugas', 'icon' => 'assignment', 'href' => '#'],
                ['key' => 'grades', 'label' => 'Nilai', 'icon' => 'grade', 'href' => '#'],
                ['key' => 'certificates', 'label' => 'Sertifikat', 'icon' => 'workspace_premium', 'href' => '#'],
                ['key' => 'profile', 'label' => 'Profil', 'icon' => 'person', 'href' => route('profile.edit')],
            ];
        }
    }
@endphp

<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col border-r border-outline-variant bg-surface p-base lg:flex">
    <div class="px-4 py-6">
        <h1 class="font-headline-md text-headline-md font-bold text-primary">{{ config('app.name', 'EduMentor') }}</h1>
        <p class="font-label-md text-label-md text-on-surface-variant">{{ $portalLabel }}</p>
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
        <details class="group relative mt-6 border-t border-outline-variant pt-6">
            <summary class="flex cursor-pointer list-none items-center gap-3 rounded-xl px-2 py-2 transition-colors hover:bg-surface-container-low focus:outline-none focus:ring-2 focus:ring-primary/20 [&::-webkit-details-marker]:hidden">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-outline-variant bg-primary-fixed font-bold text-primary">
                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-label-md text-label-md font-bold">{{ auth()->user()->name }}</p>
                    <p class="truncate text-[12px] text-on-surface-variant">{{ $userRoleLabel }}</p>
                </div>
                <span class="material-symbols-outlined text-[20px] text-on-surface-variant transition-transform group-open:rotate-180">expand_more</span>
            </summary>

            <div class="absolute bottom-full left-0 right-0 z-50 mb-3 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest py-2 shadow-lg shadow-on-surface/5">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">account_circle</span>
                    Profil
                </a>
                <a href="{{ route('profile.password.edit') }}" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                    Ubah Password
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
</aside>
