<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Tambah Kategori</title>
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
                    <h1 class="text-3xl font-bold sm:text-4xl">Tambah Kategori</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">Buat kategori baru untuk kursus di platform.</p>
                </div>
            </section>
        </header>

        <main class="mx-auto -mt-6 max-w-7xl px-6 pb-10">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Kategori</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-950 transition focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan nama kategori">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-950 transition focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">Simpan</button>
                        <a href="{{ route('categories.index') }}" class="rounded-lg border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>