@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Ubah Password')
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-surface antialiased')

@section('body')
    @if (auth()->user()->role === 'admin')
        <x-admin.sidebar active="profile" />
        <x-admin.header placeholder="Cari..." show-admin-label />
    @endif

    <main class="min-h-screen {{ auth()->user()->role === 'admin' ? 'pt-16 lg:ml-64' : '' }}">
        <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
            <div class="mb-8">
                <a href="{{ route('profile.edit') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali ke Profil
                </a>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Ubah Password</h1>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Gunakan password baru yang mudah diingat dan tidak digunakan di tempat lain.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-secondary-container bg-secondary-container/30 px-6 py-4 font-label-md text-label-md text-on-secondary-container">
                    {{ session('success') }}
                </div>
            @endif

            <section class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm md:p-8">
                <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Password Saat Ini</label>
                        <div class="relative">
                            <input id="current_password" type="password" name="current_password" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 pr-12 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" autocomplete="current-password">
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant transition-colors hover:text-primary" type="button" data-password-toggle="current_password" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Password Baru</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 pr-12 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" autocomplete="new-password">
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant transition-colors hover:text-primary" type="button" data-password-toggle="password" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" autocomplete="new-password">
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Password
                        </button>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center rounded-lg border border-outline-variant px-6 py-3 font-label-md text-label-md font-bold text-on-surface-variant transition hover:bg-surface-container-low">Batal</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection
