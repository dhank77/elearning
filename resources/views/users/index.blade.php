@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Daftar User')
@section('bodyClass', 'bg-background font-body-md text-on-surface antialiased')

@section('body')
        <x-admin.sidebar active="users" />

        <x-admin.header placeholder="Cari user..." />

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
@endsection
