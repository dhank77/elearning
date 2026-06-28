@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Student Dashboard')
@section('bodyClass', 'overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@section('body')
        <x-admin.sidebar
            active="dashboard"
            action-label="Lanjut Belajar"
            action-icon="play_circle"
        />

        <x-admin.header placeholder="Cari kursus, tugas, atau materi..." show-notifications />

        <main class="min-h-screen pt-16 lg:ml-64">
            <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-secondary-container bg-secondary-container/30 px-6 py-4 font-label-md text-label-md text-on-secondary-container">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 rounded-xl border border-primary-container bg-primary-container/20 px-6 py-4 font-label-md text-label-md text-primary">
                        {{ session('info') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-error/20 bg-error/10 px-6 py-4 font-label-md text-label-md text-error">
                        {{ session('error') }}
                    </div>
                @endif

                <section class="mb-10">
                    <h1 class="mb-2 font-headline-lg text-headline-lg text-on-surface">Selamat Datang, {{ auth()->user()->name }}</h1>
                    <p class="max-w-2xl text-body-lg text-on-surface-variant">
                        Kamu memiliki <strong>{{ $enrolledCourses->count() }}</strong> kursus yang telah dibeli.
                        @if($totalSpent > 0)
                            Total investasi pembelajaran: <strong>Rp {{ number_format($totalSpent, 0, ',', '.') }}</strong>.
                        @endif
                    </p>
                </section>

                <div class="grid grid-cols-1 gap-gutter xl:grid-cols-3">
                    <div class="flex flex-col gap-10 xl:col-span-2">
                        <section>
                            <div class="mb-6 flex items-center justify-between gap-4">
                                <h3 class="font-headline-md text-headline-md text-on-surface">Kursus Saya</h3>
                                @if($enrolledCourses->count() > 6)
                                    <a class="text-label-md font-bold text-primary hover:underline" href="{{ route('student.courses') }}">Lihat Semua</a>
                                @endif
                            </div>

                            @forelse($enrolledCourses->take(6)->chunk(2) as $chunk)
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2{{ $loop->first ? '' : ' mt-6' }}">
                                    @foreach($chunk as $course)
                                        <article class="bento-card flex flex-col gap-4 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4">
                                            <div class="h-32 overflow-hidden rounded-xl bg-surface-container-high">
                                                @if($course->cover_image_path)
                                                    <img alt="{{ $course->title }}" class="h-full w-full object-cover" src="{{ asset('storage/' . $course->cover_image_path) }}">
                                                @else
                                                    <div class="flex h-full items-center justify-center text-on-surface-variant">
                                                        <span class="material-symbols-outlined text-4xl">school</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-body-md font-bold text-on-surface">{{ $course->title }}</h4>
                                                <p class="text-label-md text-on-surface-variant">Oleh {{ $course->teacher->name }}</p>
                                                <p class="text-label-md text-on-surface-variant">{{ $course->modules_count }} modul</p>
                                            </div>
                                            <div class="mt-2">
                                                <a href="{{ route('student.learn', $course) }}" class="mt-2 inline-flex items-center gap-1 text-label-md font-bold text-primary hover:underline">
                                                    Lanjut Belajar
                                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                                </a>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @empty
                                <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 text-center">
                                    <span class="material-symbols-outlined mb-4 text-6xl text-on-surface-variant">shopping_cart</span>
                                    <h4 class="text-body-md font-bold text-on-surface">Belum ada kursus yang dibeli</h4>
                                    <p class="mt-2 text-label-md text-on-surface-variant">Mulai jelajahi kursus yang tersedia dan mulai pembelajaranmu.</p>
                                </div>
                            @endforelse
                        </section>

                        @if($recommendedCourses->isNotEmpty())
                        <section>
                            <div class="mb-6 flex items-center justify-between gap-4">
                                <h3 class="font-headline-md text-headline-md text-on-surface">Rekomendasi Untukmu</h3>
                                @if($recommendedCourses->count() > 2)
                                <div class="flex gap-2">
                                    <button class="rounded-full border border-outline-variant p-2 transition-colors hover:bg-surface-container-high" type="button" aria-label="Previous recommendation">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <button class="rounded-full border border-outline-variant p-2 transition-colors hover:bg-surface-container-high" type="button" aria-label="Next recommendation">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>
                                @endif
                            </div>

                            <div class="custom-scrollbar flex gap-6 overflow-x-auto pb-4">
                                @foreach($recommendedCourses as $recommended)
                                <article class="bento-card group min-w-[280px] cursor-pointer overflow-hidden rounded-2xl border border-outline-variant bg-surface-container-lowest">
                                    <div class="relative h-40">
                                        @if($recommended->cover_image_path)
                                            <img alt="{{ $recommended->title }}" class="h-full w-full object-cover" src="{{ asset('storage/' . $recommended->cover_image_path) }}">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-surface-container-high text-on-surface-variant">
                                                <span class="material-symbols-outlined text-4xl">menu_book</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-primary/20 transition-all group-hover:bg-transparent"></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-2 flex items-start justify-between gap-3">
                                            <h4 class="text-body-md font-bold text-on-surface">{{ $recommended->title }}</h4>
                                            @if($recommended->price > 0)
                                                <span class="text-label-md font-bold text-on-surface-variant">Rp {{ number_format($recommended->price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-label-md font-bold text-primary">Gratis</span>
                                            @endif
                                        </div>
                                        <p class="mb-4 text-label-md text-on-surface-variant">{!! Str::limit($recommended->description, 80) !!}</p>
                                        <div class="flex items-center justify-between gap-4">
                                            <span class="font-bold text-primary">{{ $recommended->teacher->name }}</span>
                                            <a href="{{ route('courses.show', $recommended) }}" class="group flex items-center gap-1 text-label-md font-bold text-primary">
                                                Detail <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                                @endforeach
                            </div>
                        </section>
                        @endif
                    </div>

                    <aside class="flex flex-col gap-gutter">
                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <h3 class="mb-6 font-bold text-body-lg text-on-surface">Ringkasan Pembayaran</h3>
                            @forelse($paidOrders->take(5) as $order)
                                <div class="mb-4 flex items-center gap-3 border-b border-outline-variant pb-4 last:mb-0 last:border-b-0 last:pb-0">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-success-container text-on-success-container">
                                        <span class="material-symbols-outlined">check_circle</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-bold text-label-md">{{ $order->course->title }}</p>
                                        <p class="text-[12px] text-on-surface-variant">{{ $order->order_number }}</p>
                                        <p class="text-[12px] text-on-surface-variant">{{ $order->paid_at?->format('d M Y, H:i') }}</p>
                                    </div>
                                    <span class="font-bold text-label-md text-on-surface">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                                </div>
                            @empty
                                <div class="text-center">
                                    <span class="material-symbols-outlined mb-2 text-4xl text-on-surface-variant">receipt_long</span>
                                    <p class="text-label-md text-on-surface-variant">Belum ada pembayaran</p>
                                </div>
                            @endforelse
                            @if($paidOrders->count() > 5)
                                <button class="mt-4 w-full rounded-xl border border-outline py-3 text-label-md font-bold text-on-surface transition-colors hover:bg-surface-container-low" type="button">
                                    Lihat Semua Riwayat
                                </button>
                            @endif
                        </section>

                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <h3 class="mb-6 font-bold text-body-lg text-on-surface">Statistik Pembelajaran</h3>
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-label-md text-on-surface-variant">Kursus Dibeli</span>
                                    <span class="font-bold text-body-md text-on-surface">{{ $paidOrders->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-label-md text-on-surface-variant">Kursus Aktif</span>
                                    <span class="font-bold text-body-md text-on-surface">{{ $enrolledCourses->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between border-t border-outline-variant pt-4">
                                    <span class="text-label-md text-on-surface-variant">Total Investasi</span>
                                    <span class="font-bold text-body-md text-primary">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </main>

        <x-shared.footer variant="band" show-brand show-contact />
@endsection
