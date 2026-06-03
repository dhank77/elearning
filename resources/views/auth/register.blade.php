<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Register</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-900 antialiased">
        <main class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,#2563eb_0,#0f172a_42%,#020617_78%)] px-6 py-10">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-lg border border-white/15 bg-white shadow-2xl shadow-blue-950/40 lg:grid-cols-[1.05fr_0.95fr]">
                <section class="p-6 sm:p-10">
                    <div class="mb-8">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <span class="flex size-10 items-center justify-center rounded-lg bg-blue-600 text-lg font-bold text-white">E</span>
                            <span class="font-semibold text-slate-950">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>

                    <div class="mb-8">
                        <p class="text-sm font-medium text-blue-600">Buat akun baru</p>
                        <h1 class="mt-2 text-3xl font-bold text-slate-950">Mulai belajar hari ini</h1>
                        <p class="mt-2 text-sm text-slate-500">Daftar untuk mengakses dashboard dan mengatur progres belajar Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700">Name</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                />
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            Register
                        </button>

                        <p class="text-center text-sm text-slate-500">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Log in</a>
                        </p>
                    </form>
                </section>

                <section class="hidden bg-blue-700 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div class="rounded-lg bg-white/10 p-5">
                        <p class="text-sm text-blue-100">Rencana belajar</p>
                        <div class="mt-5 space-y-3">
                            <div class="flex items-center justify-between rounded-lg bg-white px-4 py-3 text-slate-950">
                                <span class="text-sm font-semibold">Laravel Dasar</span>
                                <span class="text-xs font-semibold text-blue-700">Mulai</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-cyan-300 px-4 py-3 text-slate-950">
                                <span class="text-sm font-semibold">UI Interaktif</span>
                                <span class="text-xs font-semibold text-cyan-900">Baru</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-white/10 px-4 py-3">
                                <span class="text-sm font-semibold">Project Akhir</span>
                                <span class="text-xs font-semibold text-blue-100">Siap</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="mb-4 inline-flex rounded-lg bg-white/15 px-3 py-1 text-sm font-medium text-blue-50">Akun gratis</p>
                        <h2 class="text-4xl font-bold leading-tight">Bangun kebiasaan belajar yang konsisten.</h2>
                        <p class="mt-5 leading-7 text-blue-100">Satu akun untuk menyimpan progres, kursus, dan aktivitas belajar Anda.</p>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
