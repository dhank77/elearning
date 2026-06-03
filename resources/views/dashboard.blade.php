<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-950 antialiased">
        <header class="bg-slate-950 text-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-blue-500 text-lg font-bold text-white">E</span>
                    <span class="text-base font-semibold">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex items-center gap-3">
                    <span class="hidden text-sm text-blue-100 sm:inline">{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:border-white/35 hover:bg-white/10">
                            Log out
                        </button>
                    </form>
                </div>
            </div>

            <section class="mx-auto max-w-7xl px-6 pb-10 pt-6">
                <div class="rounded-lg bg-blue-600 p-6 shadow-2xl shadow-blue-950/30 sm:p-8">
                    <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                        <div>
                            <p class="mb-3 inline-flex rounded-lg bg-white/15 px-3 py-1 text-sm font-medium text-blue-50">Dashboard belajar</p>
                            <h1 class="text-3xl font-bold sm:text-4xl">Halo, {{ auth()->user()->name }}!</h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">Pantau progres kursus, aktivitas terbaru, dan target belajar Anda dari satu tempat.</p>
                        </div>

                        <div class="rounded-lg bg-white px-5 py-4 text-slate-950">
                            <p class="text-sm font-medium text-slate-500">Target minggu ini</p>
                            <p class="mt-1 text-2xl font-bold text-blue-700">3 modul</p>
                        </div>
                    </div>
                </div>
            </section>
        </header>

        <main class="mx-auto -mt-6 max-w-7xl px-6 pb-10">
            <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-blue-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-500">My Courses</h2>
                            <p class="mt-2 text-3xl font-bold text-slate-950">0</p>
                        </div>
                        <span class="flex size-12 items-center justify-center rounded-lg bg-blue-100 text-lg font-bold text-blue-700">C</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Kursus yang sedang Anda ikuti.</p>
                </div>

                <div class="rounded-lg border border-emerald-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-500">Completed</h2>
                            <p class="mt-2 text-3xl font-bold text-slate-950">0</p>
                        </div>
                        <span class="flex size-12 items-center justify-center rounded-lg bg-emerald-100 text-sm font-bold text-emerald-700">OK</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Materi yang sudah diselesaikan.</p>
                </div>

                <div class="rounded-lg border border-cyan-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-500">In Progress</h2>
                            <p class="mt-2 text-3xl font-bold text-slate-950">0</p>
                        </div>
                        <span class="flex size-12 items-center justify-center rounded-lg bg-cyan-100 text-sm font-bold text-cyan-700">UP</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Materi yang sedang berjalan.</p>
                </div>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-[1fr_0.72fr]">
                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">Recent Activity</h2>
                            <p class="mt-1 text-sm text-slate-500">Aktivitas belajar terakhir akan tampil di sini.</p>
                        </div>
                        <span class="rounded-lg bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">Hari ini</span>
                    </div>

                    <div class="mt-6 rounded-lg border border-dashed border-blue-200 bg-blue-50 p-6 text-center">
                        <p class="text-sm font-semibold text-blue-700">Belum ada aktivitas</p>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Mulai dari kursus pertama Anda, lalu progres dan aktivitasnya akan muncul otomatis di dashboard.</p>
                    </div>
                </div>

                <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-950">Ringkasan</h2>
                    <div class="mt-5 space-y-4">
                        <div>
                            <div class="flex justify-between gap-4 text-sm">
                                <span class="font-medium text-slate-600">Progress mingguan</span>
                                <span class="font-bold text-blue-700">0%</span>
                            </div>
                            <div class="mt-2 h-3 overflow-hidden rounded-lg bg-slate-100">
                                <div class="h-full w-0 rounded-lg bg-blue-600"></div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-slate-700">Rekomendasi</p>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Pilih kursus baru untuk mulai mengisi progres belajar Anda.</p>
                        </div>
                    </div>
                </aside>
            </section>
        </main>
    </body>
</html>
