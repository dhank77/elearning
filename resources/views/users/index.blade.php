<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Daftar User</title>
        @fonts
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background font-body-md text-on-surface antialiased">
        <aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col border-r border-outline-variant bg-surface p-base lg:flex">
            <div class="px-4 py-6">
                <h1 class="font-headline-md text-headline-md font-bold text-primary">{{ config('app.name', 'Laravel') }}</h1>
                <p class="font-label-md text-label-md text-on-surface-variant">Admin Console</p>
            </div>

            <nav class="mt-4 flex-1 space-y-1 overflow-y-auto px-2">
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low" href="{{ route('categories.index') }}">
                    <span class="material-symbols-outlined">database</span>
                    Master Data
                </a>
                <a class="flex items-center gap-3 rounded-lg bg-surface-container-high px-4 py-3 font-label-md text-label-md font-bold text-primary" href="{{ route('users.index') }}">
                    <span class="material-symbols-outlined">group</span>
                    Users
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low" href="#">
                    <span class="material-symbols-outlined">school</span>
                    Courses
                </a>
                <a class="flex items-center gap-3 rounded-lg px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low" href="#">
                    <span class="material-symbols-outlined">settings</span>
                    Settings
                </a>
            </nav>

            <div class="mt-auto p-4">
                <div class="flex items-center gap-3 border-t border-outline-variant pt-6">
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

        <header class="fixed left-0 right-0 top-0 z-30 flex h-16 items-center justify-between border-b border-outline-variant bg-surface px-margin-mobile lg:left-64 lg:px-margin-desktop">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full rounded-full border border-outline-variant bg-surface-container-low py-2 pl-10 pr-4 font-label-md text-label-md transition-colors focus:border-primary focus:outline-none" placeholder="Cari user..." type="text">
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-full p-2 text-on-surface-variant transition-colors hover:text-primary" type="submit" aria-label="Log out">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </header>

        <main class="min-h-screen pt-16 lg:ml-64">
            <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
                <div class="mb-8">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface">Daftar User</h1>
                    <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Kelola dan pantau semua pengguna yang terdaftar di platform.</p>
                </div>

                <section class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="flex items-center justify-between border-b border-outline-variant bg-surface-bright px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-label-md text-label-md font-bold">Direktori Pengguna</span>
                            <span class="rounded bg-surface-container-high px-2 py-0.5 text-[12px] font-bold">{{ $users->total() }} User</span>
                        </div>
                        <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container" type="button" aria-label="Filter">
                            <span class="material-symbols-outlined text-[20px]">filter_list</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Nama</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Email</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Role</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                @foreach ($users as $user)
                                    <tr class="transition-colors hover:bg-surface-container-lowest">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-fixed font-bold text-primary">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-body-md text-body-md font-medium">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full bg-surface-container-high px-3 py-1 text-[12px] font-bold text-primary">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $user->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach

                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center font-label-md text-label-md text-on-surface-variant">Belum ada user yang terdaftar.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($users->hasPages())
                        <div class="flex items-center justify-between border-t border-outline-variant px-6 py-4">
                            <p class="font-label-md text-label-md text-on-surface-variant">Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} user</p>
                            <div class="flex gap-2">
                                @if ($users->onFirstPage())
                                    <span class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md text-on-surface-variant opacity-50">Prev</span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md transition-colors hover:bg-surface-container-low">Prev</a>
                                @endif

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary transition-opacity hover:opacity-90">Next</a>
                                @else
                                    <span class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary opacity-50">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </body>
</html>
