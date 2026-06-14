@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Kursus Saya')
@section('bodyClass', 'overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@section('body')
        @php
            $studentNavItems = [
                ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard')],
                ['key' => 'courses', 'label' => 'Kursus Saya', 'icon' => 'school', 'href' => route('student.courses')],
                ['key' => 'learning', 'label' => 'Pembelajaran', 'icon' => 'menu_book', 'href' => '#'],
                ['key' => 'assignments', 'label' => 'Tugas', 'icon' => 'assignment', 'href' => '#'],
                ['key' => 'grades', 'label' => 'Nilai', 'icon' => 'grade', 'href' => '#'],
                ['key' => 'certificates', 'label' => 'Sertifikat', 'icon' => 'workspace_premium', 'href' => '#'],
                ['key' => 'profile', 'label' => 'Profil', 'icon' => 'person', 'href' => route('profile.edit')],
            ];
        @endphp

        <x-admin.sidebar
            active="courses"
            :nav-items="$studentNavItems"
            portal-label="Student Portal"
            user-role-label="Student"
            action-label="Lanjut Belajar"
            action-icon="play_circle"
        />

        <x-admin.header placeholder="Cari kursus saya..." show-notifications />

        <main class="min-h-screen pt-16 lg:ml-64">
            <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
                <section class="mb-10">
                    <h1 class="mb-2 font-headline-lg text-headline-lg text-on-surface">Kursus Saya</h1>
                    <p class="max-w-2xl text-body-lg text-on-surface-variant">
                        Kamu telah membeli <strong>{{ $enrolledCourses->count() }}</strong> kursus.
                        @if($totalSpent > 0)
                            Total investasi: <strong>Rp {{ number_format($totalSpent, 0, ',', '.') }}</strong>.
                        @endif
                    </p>
                </section>

                <div class="grid grid-cols-1 gap-gutter xl:grid-cols-4">
                    <div class="xl:col-span-3">
                        @forelse($enrolledCourses as $course)
                            <article class="mb-6 flex flex-col gap-4 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4 md:flex-row">
                                <div class="h-40 w-full overflow-hidden rounded-xl bg-surface-container-high md:h-auto md:w-48 md:shrink-0">
                                    @if($course->cover_image_path)
                                        <img alt="{{ $course->title }}" class="h-full w-full object-cover" src="{{ asset('storage/' . $course->cover_image_path) }}">
                                    @else
                                        <div class="flex h-full items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined text-4xl">school</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-1 flex-col justify-between gap-3">
                                    <div>
                                        <h3 class="text-body-lg font-bold text-on-surface">{{ $course->title }}</h3>
                                        <p class="mt-1 text-label-md text-on-surface-variant">Oleh {{ $course->teacher->name }}</p>
                                        <p class="text-label-md text-on-surface-variant">{{ $course->modules_count }} modul tersedia</p>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="#" class="inline-flex items-center gap-1 rounded-xl bg-primary px-5 py-2.5 text-label-md font-bold text-on-primary transition-colors hover:bg-primary/90">
                                            <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                                            Lanjut Belajar
                                        </a>

                                        @php
                                            $order = $paidOrders->firstWhere('course_id', $course->id);
                                        @endphp
                                        @if($order)
                                            <span class="text-label-md text-on-surface-variant">
                                                Dibeli {{ $order->paid_at?->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="flex flex-col items-center justify-center rounded-2xl border border-outline-variant bg-surface-container-lowest py-16 text-center">
                                <span class="material-symbols-outlined mb-6 text-7xl text-on-surface-variant">shopping_cart</span>
                                <h3 class="text-headline-md text-on-surface">Belum ada kursus yang dibeli</h3>
                                <p class="mt-2 max-w-md text-body-lg text-on-surface-variant">Mulai jelajahi kursus yang tersedia dan temukan yang sesuai dengan kebutuhanmu.</p>
                                <a href="{{ route('welcome') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-3 text-label-md font-bold text-on-primary transition-colors hover:bg-primary/90">
                                    <span class="material-symbols-outlined text-[18px]">explore</span>
                                    Jelajahi Kursus
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <aside class="flex flex-col gap-6">
                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <h3 class="mb-4 font-bold text-body-lg text-on-surface">Ringkasan</h3>
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-label-md text-on-surface-variant">Total Kursus</span>
                                    <span class="font-bold text-body-md text-on-surface">{{ $enrolledCourses->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-label-md text-on-surface-variant">Total Modul</span>
                                    <span class="font-bold text-body-md text-on-surface">{{ $enrolledCourses->sum('modules_count') }}</span>
                                </div>
                                <div class="flex items-center justify-between border-t border-outline-variant pt-3">
                                    <span class="text-label-md text-on-surface-variant">Total Investasi</span>
                                    <span class="font-bold text-body-md text-primary">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </section>

                        @if($paidOrders->isNotEmpty())
                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <h3 class="mb-4 font-bold text-body-lg text-on-surface">Riwayat Pembayaran</h3>
                            <div class="flex flex-col gap-3">
                                @foreach($paidOrders->take(5) as $order)
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-success-container text-on-success-container">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-label-md font-bold text-on-surface">{{ $order->course->title }}</p>
                                            <p class="text-[12px] text-on-surface-variant">{{ $order->paid_at?->format('d M Y') }}</p>
                                        </div>
                                        <span class="text-label-md font-bold text-on-surface">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                        @endif
                    </aside>
                </div>
            </div>
        </main>

        <x-shared.footer variant="band" show-brand show-contact />
@endsection
