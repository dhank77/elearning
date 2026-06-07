@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Master Kategori')
@section('bodyClass', 'bg-background font-body-md text-on-surface antialiased')

@section('body')
        <x-admin.sidebar active="categories" action-label="Generate Report" action-icon="assessment" />

        <x-admin.header placeholder="Cari kategori..." show-notifications show-admin-label />

        <main class="min-h-screen pt-16 lg:ml-64">
            <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
                <div class="mb-8 flex flex-col justify-between gap-6 md:flex-row md:items-center">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Manajemen Data Master</h2>
                        <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Kelola kategori kursus, metadata, dan parameter sistem global.</p>
                    </div>
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary shadow-lg shadow-primary/10 transition-all hover:scale-[1.02] hover:shadow-primary/20 active:scale-95">
                        <span class="material-symbols-outlined">add</span>
                        Tambah Kategori
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-secondary-container bg-secondary-container/30 px-6 py-4 font-label-md text-label-md text-on-secondary-container">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-8 grid grid-cols-1 gap-gutter md:grid-cols-3">
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-container/10 text-primary">
                            <span class="material-symbols-outlined">category</span>
                        </div>
                        <div>
                            <p class="font-label-md text-[12px] text-on-surface-variant">Total Kategori</p>
                            <p class="font-headline-md text-headline-md">{{ $categories->total() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary-container/30 text-secondary">
                            <span class="material-symbols-outlined">auto_stories</span>
                        </div>
                        <div>
                            <p class="font-label-md text-[12px] text-on-surface-variant">Kategori Halaman Ini</p>
                            <p class="font-headline-md text-headline-md">{{ $categories->count() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-tertiary-fixed-dim/20 text-on-tertiary-fixed-variant">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <p class="font-label-md text-[12px] text-on-surface-variant">Status Sistem</p>
                            <p class="font-headline-md text-headline-md">Aktif</p>
                        </div>
                    </div>
                </div>

                <section class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="flex items-center justify-between border-b border-outline-variant bg-surface-bright px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-label-md text-label-md font-bold">Daftar Kategori</span>
                            <span class="rounded bg-surface-container-high px-2 py-0.5 text-[12px] font-bold">{{ $categories->total() }} Items</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container" type="button" aria-label="Filter">
                                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                            </button>
                            <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container" type="button" aria-label="Download">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Nama Kategori</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Deskripsi</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Update Terakhir</th>
                                    <th class="border-b border-outline-variant px-6 py-4 text-center font-label-md text-label-md text-on-surface-variant">Status</th>
                                    <th class="border-b border-outline-variant px-6 py-4 text-right font-label-md text-label-md text-on-surface-variant">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                @foreach ($categories as $category)
                                    <tr class="transition-colors hover:bg-surface-container-lowest">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                    <span class="material-symbols-outlined text-[18px]">category</span>
                                                </div>
                                                <span class="font-body-md text-body-md font-medium">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="max-w-md px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $category->description ?? '-' }}</td>
                                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $category->updated_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="rounded-full bg-secondary-container/30 px-3 py-1 text-[12px] font-bold text-secondary">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('categories.edit', $category) }}" class="rounded-lg p-2 text-primary transition-colors hover:bg-surface-container" aria-label="Edit {{ $category->name }}">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </a>
                                                <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-lg p-2 text-error transition-colors hover:bg-error-container/30" onclick="return confirm('Yakin ingin menghapus kategori ini?')" aria-label="Hapus {{ $category->name }}">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($categories->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center font-label-md text-label-md text-on-surface-variant">Belum ada kategori yang ditambahkan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($categories->hasPages())
                        <div class="flex items-center justify-between border-t border-outline-variant px-6 py-4">
                            <p class="font-label-md text-label-md text-on-surface-variant">Menampilkan {{ $categories->firstItem() }}-{{ $categories->lastItem() }} dari {{ $categories->total() }} kategori</p>
                            <div class="flex gap-2">
                                @if ($categories->onFirstPage())
                                    <span class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md text-on-surface-variant opacity-50">Previous</span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}" class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md transition-colors hover:bg-surface-container-low">Previous</a>
                                @endif

                                @if ($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}" class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary transition-opacity hover:opacity-90">Next</a>
                                @else
                                    <span class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary opacity-50">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </main>
@endsection
