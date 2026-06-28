@extends('layouts.app')

@section('title', config('app.name', 'EduMentor'))
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-background antialiased')

@section('body')
        <main class="min-h-screen flex flex-col relative overflow-hidden bg-background">
            {{-- Modern Grid and Blob Background Ornaments --}}
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#e5eeff_1px,transparent_1px),linear-gradient(to_bottom,#e5eeff_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-30 pointer-events-none"></div>
            <div class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] bg-primary opacity-10 rounded-full blur-[140px] pointer-events-none"></div>
            <div class="absolute bottom-[20%] left-[-10%] w-[500px] h-[500px] bg-secondary-container opacity-20 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute top-[40%] left-[30%] w-[400px] h-[400px] bg-tertiary-fixed opacity-15 rounded-full blur-[110px] pointer-events-none"></div>

            {{-- Header --}}
            <header class="mx-auto flex max-w-container-max w-full items-center justify-between gap-4 px-margin-mobile md:px-margin-desktop py-6 relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-105 transition-all duration-300">
                        <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                    </div>
                    <span class="font-headline-md text-headline-md text-primary tracking-tight font-bold">{{ config('app.name', 'EduMentor') }}</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low transition-all duration-200">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-3 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-primary/30 transition-all duration-300">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- Hero Section --}}
            <section class="mx-auto grid min-h-[calc(100vh-88px)] max-w-container-max w-full items-center gap-12 px-margin-mobile md:px-margin-desktop py-12 lg:grid-cols-2 relative z-10">
                <div class="max-w-2xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-secondary-container/20 px-4 py-2 border border-secondary-container/30">
                        <span class="material-symbols-outlined text-on-secondary-container text-[18px]" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                        <span class="font-label-md text-label-md text-on-secondary-container font-semibold">Transformasi Belajar Digital No. 1</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-on-surface mb-6 leading-tight tracking-tight">
                        Kuasai Keahlian Baru, <br>
                        <span class="text-primary bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Bangun Masa Depanmu.</span>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-8">
                        EduMentor menyediakan kurikulum terstruktur, mentor berpengalaman, dan sistem pembelajaran interaktif untuk membantu perjalanan belajarmu lebih efisien dan menyenangkan.
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                                Mulai Belajar Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md text-on-surface border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                Masuk Akun
                            </a>
                        @endauth
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="mt-12 pt-8 border-t border-outline-variant/30 flex flex-wrap items-center gap-8">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full bg-primary-fixed border-2 border-background flex items-center justify-center font-label-md text-label-md text-on-primary-fixed font-bold shadow-md">IA</div>
                                <div class="w-10 h-10 rounded-full bg-secondary-fixed border-2 border-background flex items-center justify-center font-label-md text-label-md text-on-secondary-fixed font-bold shadow-md">RH</div>
                                <div class="w-10 h-10 rounded-full bg-tertiary-fixed border-2 border-background flex items-center justify-center font-label-md text-label-md text-on-tertiary-fixed font-bold shadow-md">SM</div>
                            </div>
                            <div>
                                <span class="block font-label-md text-label-md text-on-surface font-bold">12,000+ Siswa</span>
                                <span class="block font-label-sm text-label-sm text-on-surface-variant">Telah bergabung bulan ini</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-tertiary">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star_half</span>
                            <span class="font-label-md text-label-md text-on-surface-variant font-medium ml-1">4.8/5.0 Rating</span>
                        </div>
                    </div>
                </div>

                {{-- Dashboard Preview Showcase --}}
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-secondary/15 rounded-3xl blur-2xl pointer-events-none"></div>
                    <div class="relative bg-surface-container-lowest rounded-3xl border border-outline-variant p-6 shadow-2xl space-y-6">
                        {{-- Workspace Preview Header --}}
                        <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-3.5 h-3.5 rounded-full bg-red-500"></span>
                                <span class="w-3.5 h-3.5 rounded-full bg-yellow-500"></span>
                                <span class="w-3.5 h-3.5 rounded-full bg-green-500"></span>
                                <span class="ml-2 font-label-md text-label-md text-on-surface-variant font-medium">Dashboard Siswa</span>
                            </div>
                            <span class="flex items-center gap-1 text-primary text-[14px]">
                                <span class="size-2 rounded-full bg-green-500 animate-pulse"></span> Live Sync
                            </span>
                        </div>

                        {{-- Progress Card --}}
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-6">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface-variant">Progress Belajar Anda</p>
                                    <p class="mt-1 font-headline-lg text-headline-lg text-on-surface font-extrabold">78% Selesai</p>
                                </div>
                                <div class="flex size-14 items-center justify-center rounded-xl bg-secondary-container text-on-secondary-container">
                                    <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                                </div>
                            </div>
                            <div class="mt-5 h-3.5 overflow-hidden rounded-full bg-surface-container-highest">
                                <div class="h-full w-[78%] rounded-full bg-secondary shadow-md transition-all duration-500"></div>
                            </div>
                        </div>

                        {{-- Quick Stats & Active Class --}}
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-5 flex items-center gap-4">
                                <div class="flex size-12 items-center justify-center rounded-xl bg-primary-container text-on-primary-container shrink-0">
                                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">school</span>
                                </div>
                                <div>
                                    <p class="font-headline-md text-headline-md text-on-surface font-bold">14</p>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant">Kursus Aktif</p>
                                </div>
                            </div>
                            <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-5 flex items-center gap-4">
                                <div class="flex size-12 items-center justify-center rounded-xl bg-tertiary-container text-on-tertiary-container shrink-0">
                                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                                </div>
                                <div>
                                    <p class="font-headline-md text-headline-md text-on-surface font-bold">8</p>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant">Sertifikat Resmi</p>
                                </div>
                            </div>
                        </div>

                        {{-- Active Class Detail --}}
                        <div class="rounded-2xl border border-outline-variant bg-surface px-5 py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-[24px]" style="font-variation-settings: 'FILL' 1;">developer_board</span>
                                <div>
                                    <span class="block font-label-md text-label-md text-on-surface font-bold">Sesi Live: Backend Development</span>
                                    <span class="block font-label-sm text-label-sm text-on-surface-variant">Mulai dalam 15 menit</span>
                                </div>
                            </div>
                            <span class="rounded-xl bg-primary-fixed px-3 py-1.5 font-label-sm text-label-sm text-on-primary-fixed font-bold">09:00 WIB</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Stat Metrics Banner Section --}}
            <section class="bg-surface-container-low py-12 relative border-y border-outline-variant/30">
                <div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <span class="block font-display-lg text-display-lg text-primary font-extrabold mb-1">98%</span>
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Tingkat Kelulusan</span>
                    </div>
                    <div>
                        <span class="block font-display-lg text-display-lg text-primary font-extrabold mb-1">150+</span>
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Instruktur Ahli</span>
                    </div>
                    <div>
                        <span class="block font-display-lg text-display-lg text-primary font-extrabold mb-1">300+</span>
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Materi Praktik</span>
                    </div>
                    <div>
                        <span class="block font-display-lg text-display-lg text-primary font-extrabold mb-1">24/7</span>
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Dukungan Komunitas</span>
                    </div>
                </div>
            </section>

            {{-- Courses Section --}}
            <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-24 relative z-10">
                <div class="text-center mb-16">
                    <div class="mb-3 inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 font-label-sm text-label-sm text-primary font-bold">
                        <span class="material-symbols-outlined text-[16px]">bookmark_heart</span> KURSUS TERBAIK
                    </div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4 font-bold">Investasikan Masa Depanmu Hari Ini</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Pilih dari rangkaian kursus terpopuler kami yang disusun oleh para profesional industri.</p>
                </div>

                @if ($courses->count() > 0)
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($courses as $course)
                            <div class="group bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0px_12px_40px_rgba(0,0,0,0.1)] transition-all duration-300 flex flex-col h-full">
                                <div class="aspect-video w-full overflow-hidden bg-surface-container relative">
                                    @if ($course->cover_image_path)
                                        <img src="{{ asset('storage/' . $course->cover_image_path) }}" alt="{{ $course->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-on-surface-variant/30 text-[64px]">menu_book</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3 bg-inverse-surface/80 backdrop-blur-md text-inverse-on-surface rounded-full px-3 py-1 font-label-sm text-label-sm font-semibold">
                                        Populer
                                    </div>
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <a href="{{ route('courses.show', $course->id) }}" class="block mb-2">
                                            <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors line-clamp-2 font-bold">{{ $course->title }}</h3>
                                        </a>
                                        <p class="font-label-md text-label-md text-on-surface-variant mb-4 flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                                            {{ $course->teacher->name }}
                                        </p>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-outline-variant/30 flex items-center justify-between">
                                        <div>
                                            <span class="block text-[11px] text-on-surface-variant font-semibold uppercase tracking-wider">Harga Kursus</span>
                                            <span class="font-headline-sm text-headline-sm text-primary font-extrabold">
                                                Rp {{ number_format($course->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <form action="{{ auth() ? route('checkout.store', $course) : route('login') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="manual_transfer">
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 font-label-md text-label-md bg-primary text-on-primary hover:bg-primary-container shadow-md shadow-primary/10 hover:shadow-lg transition-all duration-200">
                                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                                                Daftar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 flex justify-center">
                        {{ $courses->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-surface-container-low rounded-3xl border border-outline-variant/50">
                        <span class="material-symbols-outlined text-on-surface-variant/50 text-[64px]">menu_book</span>
                        <p class="mt-4 font-body-lg text-body-lg text-on-surface-variant">Belum ada kursus yang tersedia saat ini.</p>
                    </div>
                @endif
            </section>

            {{-- Why Choose Us / Features Section --}}
            <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-24 relative z-10 border-t border-outline-variant/30">
                <div class="text-center mb-16">
                    <div class="mb-3 inline-flex items-center gap-1 rounded-full bg-secondary-container/20 px-3 py-1 font-label-sm text-label-sm text-on-secondary-container font-bold">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span> FITUR UNGGULAN
                    </div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4 font-bold">Kenapa Memilih EduMentor?</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Kami mengedepankan kualitas pembelajaran interaktif dan kemudahan akses di mana saja, kapan saja.</p>
                </div>
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    {{-- Feature 1 --}}
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.04)]">
                        <div class="flex size-14 items-center justify-center rounded-xl bg-primary/10 text-primary mb-6">
                            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">list_alt</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3 font-bold">Silabus Terstruktur</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Kurikulum yang dirancang berurutan dari level pemula hingga profesional untuk mempermudah pemahaman konsep dasar dan lanjutan.</p>
                    </div>
                    {{-- Feature 2 --}}
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.04)]">
                        <div class="flex size-14 items-center justify-center rounded-xl bg-secondary-container/30 text-on-secondary-container mb-6">
                            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3 font-bold">Pelacakan Progres</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Visualisasi kemajuan belajar Anda secara waktu nyata. Tahu persis materi mana yang sudah selesai dan apa yang harus dipelajari selanjutnya.</p>
                    </div>
                    {{-- Feature 3 --}}
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 shadow-[0px_4px_20px_rgba(0,0,0,0.04)]">
                        <div class="flex size-14 items-center justify-center rounded-xl bg-tertiary-fixed text-on-tertiary-fixed mb-6">
                            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3 font-bold">Sertifikat Digital</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Dapatkan sertifikat resmi dari EduMentor setelah menyelesaikan seluruh modul yang dapat digunakan untuk memperkuat CV/Portofolio Anda.</p>
                    </div>
                </div>
            </section>

            {{-- Testimonials Section --}}
            <section class="bg-surface-container-low py-24 relative border-t border-outline-variant/30 overflow-hidden">
                <div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop relative z-10">
                    <div class="text-center mb-16">
                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4 font-bold">Apa Kata Siswa Kami?</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Cerita sukses nyata dari siswa yang berhasil mentransformasikan karir mereka.</p>
                    </div>
                    <div class="grid gap-8 md:grid-cols-3">
                        <div class="bg-surface-container-lowest border border-outline-variant p-8 rounded-2xl shadow-sm flex flex-col justify-between h-full">
                            <p class="font-body-md text-body-md text-on-surface-variant italic mb-6 leading-relaxed">"Sistem pembelajaran di EduMentor terstruktur dengan sangat baik. Progres tracker membuat saya selalu termotivasi menyelesaikan modul demi modul."</p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center font-bold text-primary">R</div>
                                <div>
                                    <span class="block font-label-md text-label-md text-on-surface font-bold">Rian Anggoro</span>
                                    <span class="block font-label-sm text-label-sm text-on-surface-variant">Web Developer @ Tech Corp</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest border border-outline-variant p-8 rounded-2xl shadow-sm flex flex-col justify-between h-full">
                            <p class="font-body-md text-body-md text-on-surface-variant italic mb-6 leading-relaxed">"Penjelasan instruktur sangat mudah dimengerti bahkan untuk saya yang tidak memiliki latar belakang IT. Sertifikatnya langsung bisa saya lampirkan di LinkedIn."</p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center font-bold text-secondary">A</div>
                                <div>
                                    <span class="block font-label-md text-label-md text-on-surface font-bold">Amelia Putri</span>
                                    <span class="block font-label-sm text-label-sm text-on-surface-variant">UI/UX Designer Freelancer</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest border border-outline-variant p-8 rounded-2xl shadow-sm flex flex-col justify-between h-full">
                            <p class="font-body-md text-body-md text-on-surface-variant italic mb-6 leading-relaxed">"Fitur EduBot asisten virtual sangat membantu menjawab pertanyaan mendadak di malam hari mengenai modul pembelajaran. Highly recommended!"</p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-tertiary-fixed-dim/20 rounded-full flex items-center justify-center font-bold text-on-tertiary-fixed-variant">H</div>
                                <div>
                                    <span class="block font-label-md text-label-md text-on-surface font-bold">Hendra Wijaya</span>
                                    <span class="block font-label-sm text-label-sm text-on-surface-variant">Siswa Bootcamp Data Science</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FAQ Section --}}
            <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-24 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4 font-bold">Frequently Asked Questions</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Butuh informasi lebih lanjut? Berikut pertanyaan-pertanyaan yang sering diajukan.</p>
                </div>
                <div class="max-w-3xl mx-auto space-y-4">
                    {{-- FAQ Item 1 --}}
                    <div class="faq-item border border-outline-variant bg-surface-container-lowest rounded-2xl overflow-hidden">
                        <button class="w-full flex items-center justify-between p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                            <span class="font-label-md text-label-md text-on-surface font-bold">Bagaimana cara mendaftar kursus di EduMentor?</span>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 border-t border-outline-variant/30 pt-4">
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Cukup buat akun gratis terlebih dahulu dengan klik tombol "Register", pilih kursus yang Anda inginkan di halaman utama, kemudian lakukan proses checkout/pembayaran.</p>
                        </div>
                    </div>
                    {{-- FAQ Item 2 --}}
                    <div class="faq-item border border-outline-variant bg-surface-container-lowest rounded-2xl overflow-hidden">
                        <button class="w-full flex items-center justify-between p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                            <span class="font-label-md text-label-md text-on-surface font-bold">Metode pembayaran apa saja yang didukung?</span>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 border-t border-outline-variant/30 pt-4">
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Kami mendukung Transfer Bank Manual dan sedang dalam integrasi dengan sistem pembayaran otomatis untuk kenyamanan Anda.</p>
                        </div>
                    </div>
                    {{-- FAQ Item 3 --}}
                    <div class="faq-item border border-outline-variant bg-surface-container-lowest rounded-2xl overflow-hidden">
                        <button class="w-full flex items-center justify-between p-6 text-left focus:outline-none" onclick="toggleFaq(this)">
                            <span class="font-label-md text-label-md text-on-surface font-bold">Apakah sertifikat yang didapat berlaku selamanya?</span>
                            <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6 border-t border-outline-variant/30 pt-4">
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Ya, sertifikat kelulusan kursus digital Anda berlaku selamanya dan terverifikasi secara unik dengan ID sertifikat di sistem EduMentor.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Footer Section --}}
            <footer class="bg-surface-container-lowest border-t border-outline-variant py-16 relative z-10">
                <div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="space-y-4">
                        <a href="{{ url('/') }}" class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-md">
                                <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                            </div>
                            <span class="font-headline-md text-headline-md text-primary tracking-tight font-bold">{{ config('app.name', 'EduMentor') }}</span>
                        </a>
                        <p class="font-body-md text-body-md text-on-surface-variant">Platform e-learning modern yang berdedikasi tinggi untuk memajukan kapabilitas anak bangsa lewat pendidikan digital.</p>
                    </div>
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold mb-4 uppercase tracking-wider">Tautan Cepat</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">Home</a></li>
                            <li><a href="{{ route('login') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">Login</a></li>
                            <li><a href="{{ route('register') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">Register</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold mb-4 uppercase tracking-wider">Kategori Populer</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">Web Development</a></li>
                            <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">Data Science</a></li>
                            <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors">UI/UX Design</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold mb-4 uppercase tracking-wider">Hubungi Kami</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">support@edumentor.test</p>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">Gedung EduMentor Lt. 3, Jakarta, Indonesia</p>
                    </div>
                </div>
                <div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop mt-12 pt-8 border-t border-outline-variant/30 text-center">
                    <p class="font-label-sm text-label-sm text-on-surface-variant">&copy; {{ date('Y') }} {{ config('app.name', 'EduMentor') }}. All rights reserved.</p>
                </div>
            </footer>

            {{-- Chatbot Widget --}}
            <div id="chatbot" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">
                {{-- Chat Panel --}}
                <div id="chat-panel" class="hidden w-[380px] max-h-[520px] rounded-2xl border border-outline-variant bg-surface-container-lowest shadow-[0px_8px_40px_rgba(0,0,0,0.15)] overflow-hidden flex-col">
                    {{-- Header --}}
                    <div class="flex items-center justify-between gap-3 bg-primary px-5 py-4 shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="flex size-9 items-center justify-center rounded-full bg-white/20">
                                <span class="material-symbols-outlined text-white text-[20px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-primary font-bold">EduBot</p>
                                <p class="font-label-sm text-label-sm text-on-primary/80">Online</p>
                            </div>
                        </div>
                        <button id="chat-close" class="rounded-lg p-1.5 text-on-primary hover:bg-white/20 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>

                    {{-- Messages --}}
                    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-[320px] max-h-[380px] bg-surface">
                        <div class="flex gap-2">
                            <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                <span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                            </div>
                            <div class="max-w-[80%] rounded-2xl rounded-tl-md bg-surface-container-low px-4 py-2.5 border border-outline-variant/50">
                                <p class="font-body-md text-body-md text-on-surface">Halo! 👋 Saya EduBot, asisten virtual EduMentor. Ada yang bisa saya bantu?</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-7 shrink-0"></div>
                            <div class="max-w-[80%] rounded-2xl rounded-tl-md bg-surface-container-low px-4 py-2.5 border border-outline-variant/50">
                                <p class="font-body-md text-body-md text-on-surface">Anda bisa bertanya tentang:</p>
                                <ul class="mt-2 space-y-1 font-body-sm text-body-sm text-on-surface-variant">
                                    <li>• Cara mendaftar kursus</li>
                                    <li>• Metode pembayaran</li>
                                    <li>• Sertifikat</li>
                                    <li>• Fitur platform</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Replies --}}
                    <div id="quick-replies" class="flex shrink-0 gap-2 px-4 pb-2 bg-surface overflow-x-auto">
                        <button data-query="cara daftar" class="shrink-0 rounded-full border border-outline-variant bg-surface-container-low px-3 py-1.5 font-label-sm text-label-sm text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-colors">Cara Daftar</button>
                        <button data-query="metode pembayaran" class="shrink-0 rounded-full border border-outline-variant bg-surface-container-low px-3 py-1.5 font-label-sm text-label-sm text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-colors">Pembayaran</button>
                        <button data-query="sertifikat" class="shrink-0 rounded-full border border-outline-variant bg-surface-container-low px-3 py-1.5 font-label-sm text-label-sm text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-colors">Sertifikat</button>
                        <button data-query="fitur" class="shrink-0 rounded-full border border-outline-variant bg-surface-container-low px-3 py-1.5 font-label-sm text-label-sm text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-colors">Fitur</button>
                    </div>

                    {{-- Input --}}
                    <div class="flex items-center gap-2 border-t border-outline-variant/50 bg-surface-container-low p-3 shrink-0">
                        <input id="chat-input" type="text" placeholder="Ketik pertanyaan..." class="flex-1 rounded-xl border border-outline-variant bg-surface px-4 py-2.5 font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant/50 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20 transition-colors">
                        <button id="chat-send" class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary text-on-primary hover:bg-primary-container transition-colors">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">send</span>
                        </button>
                    </div>
                </div>

                {{-- Toggle Button --}}
                <button id="chat-toggle" class="flex size-14 items-center justify-center rounded-full bg-primary text-on-primary shadow-lg shadow-primary/30 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/40 transition-all duration-300 active:scale-95">
                    <span id="chat-icon" class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                </button>
            </div>
        </main>

        @push('scripts')
        <script>
        function toggleFaq(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('.material-symbols-outlined');
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        (function() {
            const toggle = document.getElementById('chat-toggle');
            const panel = document.getElementById('chat-panel');
            const closeBtn = document.getElementById('chat-close');
            const input = document.getElementById('chat-input');
            const sendBtn = document.getElementById('chat-send');
            const messages = document.getElementById('chat-messages');
            const icon = document.getElementById('chat-icon');
            const quickReplies = document.getElementById('quick-replies');

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                ?? document.querySelector('input[name="_token"]')?.value
                ?? '';

            async function fetchAnswer(query) {
                try {
                    const res = await fetch("{{ route('chatbot.ask') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ question: query }),
                    });

                    if (!res.ok) {
                        const err = await res.json().catch(() => ({}));
                        return err.answer ?? 'Maaf, saya tidak dapat menjawab saat ini. Silakan coba beberapa saat lagi.';
                    }

                    const data = await res.json();
                    return data.answer ?? 'Maaf, saya tidak dapat menjawab saat ini.';
                } catch (e) {
                    return 'Maaf, terjadi kesalahan koneksi. Periksa internet Anda dan coba lagi.';
                }
            }

            function addMessage(text, isUser = false, save = true) {
                const msg = document.createElement('div');
                msg.className = 'flex gap-2 ' + (isUser ? 'justify-end' : '');

                if (isUser) {
                    msg.innerHTML = `
                        <div class="max-w-[80%] rounded-2xl rounded-tr-md bg-primary px-4 py-2.5">
                            <p class="font-body-md text-body-md text-on-primary">${escapeHtml(text)}</p>
                        </div>
                    `;
                } else {
                    const formatted = formatBotResponse(text);
                    msg.innerHTML = `
                        <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary/10">
                            <span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                        </div>
                        <div class="max-w-[80%] rounded-2xl rounded-tl-md bg-surface-container-low px-4 py-2.5 border border-outline-variant/50">
                            <p class="font-body-md text-body-md text-on-surface">${formatted}</p>
                        </div>
                    `;
                }

                messages.appendChild(msg);
                messages.scrollTop = messages.scrollHeight;

                if (save) {
                    try {
                        const history = JSON.parse(localStorage.getItem('edubot_chat_history') || '[]');
                        history.push({ text, isUser });
                        localStorage.setItem('edubot_chat_history', JSON.stringify(history));
                    } catch (e) {
                        console.error('Failed to save chat history', e);
                    }
                }
            }

            function addTypingIndicator() {
                const typing = document.createElement('div');
                typing.id = 'typing-indicator';
                typing.className = 'flex gap-2';
                typing.innerHTML = `
                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary/10">
                        <span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                    </div>
                    <div class="rounded-2xl rounded-tl-md bg-surface-container-low px-4 py-2.5 border border-outline-variant/50">
                        <div class="flex gap-1">
                            <span class="size-2 rounded-full bg-on-surface-variant/30 animate-bounce" style="animation-delay: 0ms"></span>
                            <span class="size-2 rounded-full bg-on-surface-variant/30 animate-bounce" style="animation-delay: 150ms"></span>
                            <span class="size-2 rounded-full bg-on-surface-variant/30 animate-bounce" style="animation-delay: 300ms"></span>
                        </div>
                    </div>
                `;
                messages.appendChild(typing);
                messages.scrollTop = messages.scrollHeight;
            }

            function removeTypingIndicator() {
                const el = document.getElementById('typing-indicator');
                if (el) el.remove();
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function formatBotResponse(text) {
                let html = escapeHtml(text);
                html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                html = html.replace(/\n/g, '<br>');
                return html;
            }

            async function sendMessage(query) {
                if (!query.trim()) return;

                addMessage(query, true);
                input.value = '';

                addTypingIndicator();

                const answer = await fetchAnswer(query);
                removeTypingIndicator();
                addMessage(answer);
            }

            let isOpen = false;

            function openChat() {
                isOpen = true;
                panel.classList.remove('hidden');
                panel.classList.add('flex');
                icon.textContent = 'close';
                quickReplies.style.display = 'flex';
                messages.scrollTop = messages.scrollHeight;
                setTimeout(() => input.focus(), 100);
            }

            function closeChat() {
                isOpen = false;
                panel.classList.add('hidden');
                panel.classList.remove('flex');
                icon.textContent = 'chat';
                quickReplies.style.display = 'none';
            }

            toggle.addEventListener('click', () => {
                if (isOpen) closeChat();
                else openChat();
            });

            closeBtn.addEventListener('click', closeChat);

            sendBtn.addEventListener('click', () => sendMessage(input.value));

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage(input.value);
            });

            quickReplies.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-query]');
                if (btn) {
                    sendMessage(btn.dataset.query);
                }
            });

            // Load saved history on load
            try {
                const history = JSON.parse(localStorage.getItem('edubot_chat_history') || '[]');
                history.forEach(msg => {
                    addMessage(msg.text, msg.isUser, false);
                });
            } catch (e) {
                console.error('Failed to load chat history', e);
            }
        })();
        </script>
        @endpush
    @endsection
