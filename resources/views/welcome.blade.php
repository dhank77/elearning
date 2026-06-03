<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-white antialiased">
        <main class="min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,#1d4ed8_0,#0f172a_34%,#020617_72%)]">
            <header class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-6">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-white text-lg font-bold text-blue-700 shadow-lg shadow-blue-950/30">E</span>
                    <span class="text-base font-semibold">{{ config('app.name', 'Laravel') }}</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-2 text-sm font-medium">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-lg border border-white/15 px-4 py-2 text-white transition hover:border-white/35 hover:bg-white/10">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-blue-100 transition hover:bg-white/10 hover:text-white">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-lg bg-white px-4 py-2 text-blue-700 shadow-lg shadow-blue-950/30 transition hover:bg-blue-50">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <section class="mx-auto grid min-h-[calc(100vh-88px)] max-w-7xl items-center gap-10 px-6 py-10 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="max-w-3xl">
                    <p class="mb-5 inline-flex rounded-lg border border-cyan-300/30 bg-cyan-300/10 px-3 py-1 text-sm font-medium text-cyan-100">
                        Platform belajar online
                    </p>
                    <h1 class="text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl">
                        Belajar lebih rapi, fokus, dan menyenangkan.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-blue-100 sm:text-lg">
                        Kelola kursus, pantau progres, dan mulai perjalanan belajar dari dashboard yang ringan dipakai setiap hari.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-lg bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-blue-950/40 transition hover:bg-blue-400">Buka Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex justify-center rounded-lg bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-blue-950/40 transition hover:bg-blue-400">Mulai Sekarang</a>
                            <a href="{{ route('login') }}" class="inline-flex justify-center rounded-lg border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:border-white/40 hover:bg-white/10">Masuk Akun</a>
                        @endauth
                    </div>
                </div>

                <div class="grid gap-4">
                    <div class="rounded-lg border border-white/15 bg-white/10 p-5 shadow-2xl shadow-blue-950/30 backdrop-blur">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm text-blue-100">Progress Belajar</p>
                                <p class="mt-1 text-3xl font-bold">72%</p>
                            </div>
                            <div class="flex size-14 items-center justify-center rounded-lg bg-cyan-300 text-xl font-bold text-slate-950">A</div>
                        </div>
                        <div class="mt-5 h-3 overflow-hidden rounded-lg bg-slate-900/60">
                            <div class="h-full w-[72%] rounded-lg bg-cyan-300"></div>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg border border-white/15 bg-white p-5 text-slate-900 shadow-xl shadow-blue-950/20">
                            <p class="text-sm font-medium text-slate-500">Kursus Aktif</p>
                            <p class="mt-3 text-3xl font-bold text-blue-700">12</p>
                            <p class="mt-2 text-sm text-slate-500">Materi siap dipelajari</p>
                        </div>
                        <div class="rounded-lg border border-cyan-200/60 bg-cyan-50 p-5 text-slate-900 shadow-xl shadow-blue-950/20">
                            <p class="text-sm font-medium text-slate-500">Sertifikat</p>
                            <p class="mt-3 text-3xl font-bold text-cyan-700">4</p>
                            <p class="mt-2 text-sm text-slate-500">Pencapaian terbaru</p>
                        </div>
                    </div>

                    <div class="rounded-lg border border-white/15 bg-slate-900/70 p-5">
                        <p class="text-sm font-medium text-blue-100">Jadwal Hari Ini</p>
                        <div class="mt-4 flex items-center justify-between gap-4 rounded-lg bg-white/10 px-4 py-3">
                            <span class="text-sm">Laravel Dasar</span>
                            <span class="rounded-lg bg-emerald-300 px-3 py-1 text-xs font-semibold text-emerald-950">09:00</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
