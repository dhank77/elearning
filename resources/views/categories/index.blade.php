<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Master Kategori</title>
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
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold sm:text-4xl">Master Kategori</h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">Kelola kategori kursus yang tersedia di platform.</p>
                        </div>
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-700 shadow-lg shadow-blue-950/30 transition hover:bg-blue-50">
                            + Tambah Kategori
                        </a>
                    </div>
                </div>
            </section>
        </header>

        <main class="mx-auto -mt-6 max-w-7xl px-6 pb-10">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Nama Kategori</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Deskripsi</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Dibuat</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-medium text-slate-950">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $category->description ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $category->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-100" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($categories->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada kategori yang ditambahkan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="flex items-center justify-between border-t border-slate-200 px-6 py-4">
                        <span class="text-sm text-slate-500">Menampilkan {{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }} kategori</span>

                        <div class="flex gap-2">
                            @if ($categories->onFirstPage())
                                <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-400">Prev</span>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Prev</a>
                            @endif

                            @if ($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Next</a>
                            @else
                                <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-400">Next</span>
                            @endif
                        </div>
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>