@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Profil')
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-surface antialiased')

@section('body')
    @php
        $isAdmin = auth()->user()->role === 'admin';
    @endphp

    @if ($isAdmin)
        <x-admin.sidebar active="profile" />
        <x-admin.header placeholder="Cari..." show-admin-label />
    @else
        <x-user.header />
    @endif

    @unless ($isAdmin)
        <div class="mx-auto flex max-w-container-max">
            <x-user.sidebar active="profile" />
    @endunless

    <main class="min-h-screen {{ $isAdmin ? 'pt-16 lg:ml-64' : 'min-w-0 flex-1' }}">
        <div class="{{ $isAdmin ? 'mx-auto max-w-[1280px]' : '' }} p-margin-mobile md:p-margin-desktop">
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali ke Dashboard
                </a>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Profil Saya</h1>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Perbarui nama, email, dan nomor WhatsApp akun Anda.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-secondary-container bg-secondary-container/30 px-6 py-4 font-label-md text-label-md text-on-secondary-container">
                    {{ session('success') }}
                </div>
            @endif

            <section class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm md:p-8">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan nama">
                        @error('name')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Nomor WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Profil
                        </button>
                        <a href="{{ route('profile.password.edit') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-outline-variant px-6 py-3 font-label-md text-label-md font-bold text-on-surface-variant transition hover:bg-surface-container-low">
                            <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                            Ubah Password
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </main>

    @unless ($isAdmin)
        </div>
    @endunless
@endsection
