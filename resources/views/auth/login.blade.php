<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-900 antialiased">
        <main class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,#2563eb_0,#0f172a_42%,#020617_78%)] px-6 py-10">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-lg border border-white/15 bg-white shadow-2xl shadow-blue-950/40 lg:grid-cols-[0.95fr_1.05fr]">
                <section class="hidden bg-blue-700 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-lg bg-white text-lg font-bold text-blue-700">E</span>
                        <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>
                    </a>

                    <div>
                        <p class="mb-4 inline-flex rounded-lg bg-white/15 px-3 py-1 text-sm font-medium text-blue-50">Selamat datang kembali</p>
                        <h1 class="text-4xl font-bold leading-tight">Lanjutkan progres belajar Anda.</h1>
                        <p class="mt-5 leading-7 text-blue-100">Masuk untuk membuka dashboard, melihat kursus aktif, dan menjaga ritme belajar tetap konsisten.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-lg bg-white/10 p-4">
                            <p class="text-blue-100">Kelas aktif</p>
                            <p class="mt-2 text-2xl font-bold">12</p>
                        </div>
                        <div class="rounded-lg bg-cyan-300 p-4 text-slate-950">
                            <p class="text-slate-700">Progress</p>
                            <p class="mt-2 text-2xl font-bold">72%</p>
                        </div>
                    </div>
                </section>

                <section class="p-6 sm:p-10">
                    <div class="mb-8 lg:hidden">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <span class="flex size-10 items-center justify-center rounded-lg bg-blue-600 text-lg font-bold text-white">E</span>
                            <span class="font-semibold text-slate-950">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>

                    <div class="mb-8">
                        <p class="text-sm font-medium text-blue-600">Login akun</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-950">Masuk ke dashboard</h2>
                        <p class="mt-2 text-sm text-slate-500">Gunakan email dan password yang sudah terdaftar.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <input id="remember" type="checkbox" name="remember" class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" />
                            <label for="remember" class="text-sm text-slate-600">Remember me</label>
                        </div>

                        <button type="submit" class="w-full rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            Log in
                        </button>

                        <p class="text-center text-sm text-slate-500">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Register</a>
                        </p>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>
