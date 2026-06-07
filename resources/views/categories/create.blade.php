@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Tambah Kategori')
@section('bodyClass', 'bg-background font-body-md text-on-surface antialiased')

@section('body')
    <x-admin.sidebar active="categories" action-label="Generate Report" action-icon="assessment" />

    <x-admin.header placeholder="Cari kategori..." show-notifications show-admin-label />

    <main class="min-h-screen pt-16 lg:ml-64">
        <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
            <div class="mb-8">
                <a href="{{ route('categories.index') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali ke Master Data
                </a>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Tambah Kategori</h1>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Buat kategori baru untuk mengelompokkan kursus di platform.</p>
            </div>

            @include('categories._form', [
                'category' => null,
                'action' => route('categories.store'),
            ])
        </div>
    </main>
@endsection
