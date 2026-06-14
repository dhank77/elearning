@extends('layouts.app')

@section('title', config('app.name', 'EduMentor'))
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-background antialiased')

@section('body')
        <main class="min-h-screen flex flex-col relative overflow-hidden">
            <div class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] bg-primary-fixed opacity-20 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-[-5%] left-[-5%] w-[400px] h-[400px] bg-secondary-container opacity-20 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="absolute top-[40%] left-[30%] w-[300px] h-[300px] bg-tertiary-fixed opacity-10 rounded-full blur-[100px] pointer-events-none"></div>

            {{-- Header --}}
            <header class="mx-auto flex max-w-container-max w-full items-center justify-between gap-4 px-margin-mobile md:px-margin-desktop py-6 relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                    </div>
                    <span class="font-headline-md text-headline-md text-primary tracking-tight">{{ config('app.name', 'EduMentor') }}</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low transition-all duration-200">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container transition-all duration-300">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- Hero Section --}}
            <section class="mx-auto grid min-h-[calc(100vh-88px)] max-w-container-max w-full items-center gap-12 px-margin-mobile md:px-margin-desktop py-10 lg:grid-cols-2 relative z-10">
                <div class="max-w-2xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-xl bg-secondary-container/20 px-4 py-2 border border-secondary-container/30">
                        <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
                        <span class="font-label-md text-label-md text-secondary">Platform belajar online</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-on-surface mb-4">
                        Belajar lebih rapi, fokus, dan menyenangkan.
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-8">
                        Kelola kursus, pantau progres, dan mulai perjalanan belajar dari dashboard yang ringan dipakai setiap hari.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md text-on-surface border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                Masuk Akun
                            </a>
                        @endauth
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="mt-10 flex items-center gap-6">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full bg-primary-container border-2 border-on-primary flex items-center justify-center font-label-md text-label-md text-on-primary-container">A</div>
                            <div class="w-10 h-10 rounded-full bg-secondary border-2 border-on-primary flex items-center justify-center font-label-md text-label-md text-on-secondary">B</div>
                            <div class="w-10 h-10 rounded-full bg-tertiary-container border-2 border-on-primary flex items-center justify-center font-label-md text-label-md text-on-tertiary-container">C</div>
                        </div>
                        <div>
                            <span class="font-label-md text-label-md text-on-surface font-bold">12k+ siswa</span>
                            <span class="font-label-md text-label-md text-on-surface-variant"> bergabbul bulan ini</span>
                        </div>
                    </div>
                </div>

                {{-- Dashboard Preview Cards --}}
                <div class="grid gap-5">
                    {{-- Progress Card --}}
                    <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant">Progress Belajar</p>
                                <p class="mt-1 font-headline-lg text-headline-lg text-on-surface">72%</p>
                            </div>
                            <div class="flex size-14 items-center justify-center rounded-xl bg-secondary-container">
                                <span class="material-symbols-outlined text-on-secondary-container text-[28px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                            </div>
                        </div>
                        <div class="mt-5 h-3 overflow-hidden rounded-xl bg-surface-container">
                            <div class="h-full w-[72%] rounded-xl bg-secondary transition-all duration-500"></div>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                            <div class="flex size-10 items-center justify-center rounded-xl bg-primary-container mb-4">
                                <span class="material-symbols-outlined text-on-primary-container text-[20px]" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            </div>
                            <p class="font-headline-lg text-headline-lg text-on-surface">12</p>
                            <p class="font-label-md text-label-md text-on-surface-variant mt-1">Kursus aktif</p>
                        </div>
                        <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                            <div class="flex size-10 items-center justify-center rounded-xl bg-tertiary-container mb-4">
                                <span class="material-symbols-outlined text-on-tertiary-container text-[20px]" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                            </div>
                            <p class="font-headline-lg text-headline-lg text-on-surface">4</p>
                            <p class="font-label-md text-label-md text-on-surface-variant mt-1">Sertifikat</p>
                        </div>
                    </div>

                    {{-- Schedule Card --}}
                    <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-low p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">calendar_today</span>
                            <p class="font-label-md text-label-md text-on-surface-variant">Jadwal Hari Ini</p>
                        </div>
                        <div class="flex items-center justify-between gap-4 rounded-xl bg-surface-container px-5 py-4 border border-outline-variant/50">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">code</span>
                                <span class="font-body-md text-body-md text-on-surface">Laravel Dasar</span>
                            </div>
                            <span class="rounded-xl bg-secondary-container px-3 py-1 font-label-md text-label-md text-on-secondary-container font-bold">09:00</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Courses Section --}}
            <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-20 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-3">Kursus Tersedia</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Pilih kursus yang ingin kamu pelajari dan mulai perjalanan belajarmu.</p>
                </div>

                @if ($courses->count() > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($courses as $course)
                            <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0px_8px_30px_rgba(0,0,0,0.12)] transition-all duration-300">
                                <div class="aspect-video w-full overflow-hidden bg-surface-container">
                                    @if ($course->cover_image_path)
                                        <img src="{{ asset('storage/' . $course->cover_image_path) }}" alt="{{ $course->title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-on-surface-variant/30 text-[64px]">menu_book</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="font-headline-md text-headline-md text-on-surface mb-2 line-clamp-2">{{ $course->title }}</h3>
                                    <p class="font-label-md text-label-md text-on-surface-variant mb-1">
                                        <span class="material-symbols-outlined text-[16px] align-middle mr-1">person</span>
                                        {{ $course->teacher->name }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="font-headline-sm text-headline-sm text-primary font-bold">
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                        <form action="{{ auth() ? route('checkout.store', $course) : route('login') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="manual_transfer">
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 font-label-md text-label-md bg-primary text-on-primary hover:bg-primary-container transition-all duration-200">
                                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                                                {{ auth() ? 'Beli' : 'Login untuk Beli' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center">
                        {{ $courses->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <span class="material-symbols-outlined text-on-surface-variant/50 text-[64px]">menu_book</span>
                        <p class="mt-4 font-body-lg text-body-lg text-on-surface-variant">Belum ada kursus yang tersedia.</p>
                    </div>
                @endif
            </section>

            {{-- Features Section --}}
            <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-20 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-3">Semua yang kamu butuhkan</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Fitur-fitur yang dirancang untuk membuat pengalaman belajar lebih efektif dan menyenangkan.</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <div class="flex size-12 items-center justify-center rounded-xl bg-primary/10 mb-5">
                            <span class="material-symbols-outlined text-primary text-[24px]" style="font-variation-settings: 'FILL' 1;">playlist_add_check</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Kursus Terstruktur</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Materi tersusun rapi dari dasar hingga mahir, dengan checklist progres yang jelas.</p>
                    </div>
                    <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <div class="flex size-12 items-center justify-center rounded-xl bg-secondary/10 mb-5">
                            <span class="material-symbols-outlined text-secondary text-[24px]" style="font-variation-settings: 'FILL' 1;">insights</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Progres Real-time</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Pantau kemajuan belajar secara langsung dengan visualisasi yang mudah dipahami.</p>
                    </div>
                    <div class="bento-card rounded-xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <div class="flex size-12 items-center justify-center rounded-xl bg-tertiary/10 mb-5">
                            <span class="material-symbols-outlined text-tertiary text-[24px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Sertifikat Resmi</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Raih sertifikat yang diakui setelah menyelesaikan kursus untuk portofolio kamu.</p>
                    </div>
                </div>
            </section>

            {{-- Footer --}}

            <x-shared.footer />
        </main>
@endsection
