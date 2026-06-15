@extends('layouts.app')

@section('title', $course->title . ' - ' . config('app.name', 'EduMentor'))
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-background antialiased')

@section('body')
    <main class="min-h-screen flex flex-col">
        {{-- Header --}}
        <header class="mx-auto flex max-w-container-max w-full items-center justify-between gap-4 px-margin-mobile md:px-margin-desktop py-6">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                </div>
                <span class="font-headline-md text-headline-md text-primary tracking-tight">{{ config('app.name', 'EduMentor') }}</span>
            </a>
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 font-label-md text-label-md text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </header>

        {{-- Course Hero --}}
        <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-8">
            <div class="grid gap-8 lg:grid-cols-3">
                {{-- Cover Image --}}
                <div class="lg:col-span-2">
                    <div class="aspect-video w-full overflow-hidden rounded-2xl border border-outline-variant bg-surface-container shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        @if ($course->cover_image_path)
                            <img src="{{ asset('storage/' . $course->cover_image_path) }}" alt="{{ $course->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant/30 text-[96px]">menu_book</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Course Info Card --}}
                <div class="lg:col-span-1">
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)] lg:sticky lg:top-24">
                        <div class="mb-6">
                            <span class="font-headline-sm text-headline-sm text-primary font-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                            @if ($course->price > 0)
                                <p class="font-label-md text-label-md text-on-surface-variant mt-1">Harga one-time payment</p>
                            @else
                                <p class="font-label-md text-label-md text-primary mt-1">Kursus gratis</p>
                            @endif
                        </div>

                        <form action="{{ auth() ? route('checkout.store', $course) : route('login') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="payment_method" value="xendit">
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container transition-all duration-300 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                                {{ auth() ? 'Beli Kursus' : 'Login untuk Beli' }}
                            </button>
                        </form>

                        <div class="space-y-4 border-t border-outline-variant pt-5">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-container">
                                    <span class="material-symbols-outlined text-on-primary-container text-[20px]" style="font-variation-settings: 'FILL' 1;">school</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $course->modules->count() }} Modul</p>
                                    <p class="text-[12px] text-on-surface-variant">Total materi terstruktur</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-secondary-container">
                                    <span class="material-symbols-outlined text-on-secondary-container text-[20px]" style="font-variation-settings: 'FILL' 1;">play_lesson</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $course->modules->sum(fn ($m) => $m->lessons->count()) }} Pelajaran</p>
                                    <p class="text-[12px] text-on-surface-variant">Video dan materi belajar</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-tertiary-container">
                                    <span class="material-symbols-outlined text-on-tertiary-container text-[20px]">person</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $course->teacher->name }}</p>
                                    <p class="text-[12px] text-on-surface-variant">Instruktur</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Course Details --}}
        <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-8">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-8">
                    {{-- About --}}
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <h2 class="font-headline-md text-headline-md text-on-surface mb-4">Tentang Kursus</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant whitespace-pre-line leading-relaxed">{!! $course->description !!}</p>
                    </div>

                    {{-- Curriculum --}}
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)]">
                        <h2 class="font-headline-md text-headline-md text-on-surface mb-6">Kurikulum</h2>
                        <div class="space-y-4">
                            @foreach ($course->modules as $module)
                                <details class="group rounded-xl border border-outline-variant bg-surface-container-low open:bg-surface-container-lowest" open>
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 font-headline-sm text-headline-sm text-on-surface select-none [&::-webkit-details-marker]:hidden">
                                        <span class="flex items-center gap-3">
                                            <span class="flex size-8 items-center justify-center rounded-lg bg-primary/10 font-label-md text-label-md text-primary font-bold">{{ $module->position }}</span>
                                            {{ $module->title }}
                                        </span>
                                        <span class="material-symbols-outlined text-on-surface-variant transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="border-t border-outline-variant px-5 py-3">
                                        <ul class="space-y-1">
                                            @foreach ($module->lessons as $lesson)
                                                <li class="flex items-center gap-3 rounded-lg px-3 py-3 transition-colors hover:bg-surface-container-low">
                                                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">
                                                        @if ($lesson->content_type === 'youtube')
                                                            play_circle
                                                        @else
                                                            description
                                                        @endif
                                                    </span>
                                                    <span class="font-body-md text-body-md text-on-surface-variant">{{ $lesson->title }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Instructor Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bento-card rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.06)] lg:sticky lg:top-24">
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-5">Instruktur</h3>
                        <div class="flex items-center gap-4">
                            <div class="flex size-14 items-center justify-center rounded-2xl bg-primary-container border border-outline-variant">
                                <span class="font-headline-md text-headline-md text-on-primary-container">{{ strtoupper(mb_substr($course->teacher->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-label-lg text-label-lg text-on-surface font-bold">{{ $course->teacher->name }}</p>
                                <p class="text-label-md text-on-surface-variant">Instruktur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <x-shared.footer />
    </main>
@endsection
