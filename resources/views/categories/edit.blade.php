@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Edit Kategori')
@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-surface antialiased')

@section('body')
    <main class="mx-auto max-w-[1280px] px-margin-mobile py-margin-desktop md:px-margin-desktop">
        <div class="mb-8">
            <a href="{{ route('categories.index') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali ke Master Data
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Edit Kategori</h1>
            <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Perbarui informasi kategori <strong>{{ $category->name }}</strong>.</p>
        </div>

        @include('categories._form', [
            'category' => $category,
            'action' => route('categories.update', $category),
            'method' => 'PUT',
        ])
    </main>
@endsection
