@extends('layouts.app')

@section('title', $course->title . ' - ' . config('app.name', 'EduMentor'))
@section('bodyClass', 'overflow-x-hidden bg-background font-body-md text-on-background antialiased')

@section('body')
        <div class="flex h-screen flex-col">
            {{-- Top Bar --}}
            <header class="flex h-16 shrink-0 items-center justify-between border-b border-outline-variant bg-surface px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('student.courses') }}" class="flex items-center gap-2 text-on-surface-variant transition-colors hover:text-primary">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="hidden text-label-md font-bold sm:inline">Kembali</span>
                    </a>
                    <div class="h-6 w-px bg-outline-variant"></div>
                    <h1 class="truncate text-body-md font-bold text-on-surface">{{ $course->title }}</h1>
                </div>
                <div class="flex items-center gap-2">
                    @if($totalLessons > 0 && $activeLesson)
                        <span class="text-label-md text-on-surface-variant">
                            {{ $currentIndex + 1 }} / {{ $totalLessons }}
                        </span>
                    @endif
                </div>
            </header>

            <div class="flex flex-1 overflow-hidden">
                {{-- Main Content --}}
                <main class="flex flex-1 flex-col overflow-y-auto">
                    @if($activeLesson && $youtubeId)
                        <div class="w-full bg-black">
                            <div class="relative mx-auto aspect-video w-full max-w-5xl">
                                <iframe
                                    class="absolute inset-0 h-full w-full"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1"
                                    title="{{ $activeLesson->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    @elseif($activeLesson)
                        <div class="flex items-center justify-center bg-surface-container p-8">
                            <div class="text-center">
                                <span class="material-symbols-outlined mb-4 text-6xl text-on-surface-variant">description</span>
                                <p class="text-body-lg text-on-surface-variant">Materi ini belum tersedia.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-surface-container p-8">
                            <div class="text-center">
                                <span class="material-symbols-outlined mb-4 text-6xl text-on-surface-variant">menu_book</span>
                                <p class="text-body-lg text-on-surface-variant">Kursus ini belum memiliki materi.</p>
                            </div>
                        </div>
                    @endif

                    @if($activeLesson)
                        <div class="mx-auto w-full max-w-5xl p-4 lg:p-6">
                            <div class="mb-6">
                                <h2 class="text-headline-md text-on-surface">{{ $activeLesson->title }}</h2>
                                @php
                                    $activeModule = $course->modules->firstWhere('lessons', function ($lessons) use ($activeLesson) {
                                        return $lessons->contains('id', $activeLesson->id);
                                    });
                                @endphp
                                @if($activeModule)
                                    <p class="mt-1 text-label-md text-on-surface-variant">{{ $activeModule->title }}</p>
                                @endif
                            </div>

                            {{-- Navigation Buttons --}}
                            <div class="flex items-center justify-between gap-4 border-t border-outline-variant pt-6">
                                @if($prevLesson)
                                    @php
                                        $prevModule = $course->modules->firstWhere('lessons', function ($lessons) use ($prevLesson) {
                                            return $lessons->contains('id', $prevLesson->id);
                                        });
                                    @endphp
                                    <a
                                        href="{{ route('student.learn', ['course' => $course, 'lesson' => $prevLesson->id]) }}"
                                        class="flex items-center gap-2 rounded-xl border border-outline-variant px-4 py-3 text-label-md font-bold text-on-surface transition-colors hover:bg-surface-container-low"
                                    >
                                        <span class="material-symbols-outlined">chevron_left</span>
                                        <span class="hidden sm:inline">Sebelumnya</span>
                                        <span class="max-w-[150px] truncate text-on-surface-variant sm:max-w-[200px]">{{ $prevLesson->title }}</span>
                                    </a>
                                @else
                                    <div></div>
                                @endif

                                @if($nextLesson)
                                    @php
                                        $nextModule = $course->modules->firstWhere('lessons', function ($lessons) use ($nextLesson) {
                                            return $lessons->contains('id', $nextLesson->id);
                                        });
                                    @endphp
                                    <a
                                        href="{{ route('student.learn', ['course' => $course, 'lesson' => $nextLesson->id]) }}"
                                        class="flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-label-md font-bold text-on-primary transition-colors hover:bg-primary/90"
                                    >
                                        <span class="max-w-[150px] truncate sm:max-w-[200px]">{{ $nextLesson->title }}</span>
                                        <span class="hidden sm:inline">Selanjutnya</span>
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </main>

                {{-- Sidebar --}}
                <aside class="hidden w-80 shrink-0 flex-col border-l border-outline-variant bg-surface-container-lowest lg:flex">
                    <div class="border-b border-outline-variant p-4">
                        <h3 class="text-label-md font-bold text-on-surface">Konten Kursus</h3>
                        <p class="text-label-md text-on-surface-variant">{{ $totalLessons }} materi</p>
                    </div>

                    <div class="flex-1 overflow-y-auto">
                        @foreach($course->modules as $module)
                            <div class="border-b border-outline-variant last:border-b-0">
                                <div class="flex items-center gap-2 bg-surface-container-lowest p-3">
                                    <span class="material-symbols-outlined text-on-surface-variant">folder</span>
                                    <span class="text-label-md font-bold text-on-surface">{{ $module->title }}</span>
                                    <span class="ml-auto text-label-md text-on-surface-variant">{{ $module->lessons->count() }}</span>
                                </div>

                                @foreach($module->lessons as $lesson)
                                    @php
                                        $isCurrent = $activeLesson && $activeLesson->id === $lesson->id;
                                        $lessonIndex = $flatLessons->search(fn ($l) => $l->id === $lesson->id);
                                    @endphp
                                    <a
                                        href="{{ route('student.learn', ['course' => $course, 'lesson' => $lesson->id]) }}"
                                        class="flex items-center gap-3 px-3 py-2.5 pl-10 transition-colors {{ $isCurrent ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container-high' }}"
                                    >
                                        @if($lesson->content_type === 'youtube')
                                            <span class="material-symbols-outlined text-[18px]">{{ $isCurrent ? 'play_circle' : 'play_circle' }}</span>
                                        @else
                                            <span class="material-symbols-outlined text-[18px]">description</span>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-label-md {{ $isCurrent ? 'font-bold' : '' }}">{{ $lesson->title }}</p>
                                            <p class="text-[11px] text-on-surface-variant/70">{{ $lessonIndex + 1 }} dari {{ $totalLessons }}</p>
                                        </div>
                                        @if($isCurrent)
                                            <span class="material-symbols-outlined text-[16px] text-primary">equalizer</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
@endsection
