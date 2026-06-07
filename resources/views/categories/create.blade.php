<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Tambah Kategori</title>
        @fonts
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-background font-body-md text-on-surface antialiased">
        <main class="mx-auto max-w-[1280px] px-margin-mobile py-margin-desktop md:px-margin-desktop">
            <div class="mb-8 flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('categories.index') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        Kembali ke Master Data
                    </a>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface">Tambah Kategori</h1>
                    <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Buat kategori baru untuk mengelompokkan kursus di platform.</p>
                </div>
            </div>

            <section class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm md:p-8">
                <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Nama Kategori</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan nama kategori">
                        @error('name')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan
                        </button>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center rounded-lg border border-outline-variant px-6 py-3 font-label-md text-label-md font-bold text-on-surface-variant transition hover:bg-surface-container-low">Batal</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>
