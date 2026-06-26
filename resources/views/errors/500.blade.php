@extends('layouts.app')

@section('title', 'Server Error - EduMentor')

@section('bodyClass', 'min-h-screen bg-background font-body-md text-on-background antialiased')

@section('body')
<main class="min-h-screen flex flex-col relative overflow-hidden bg-background">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#e5eeff_1px,transparent_1px),linear-gradient(to_bottom,#e5eeff_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-30 pointer-events-none"></div>
    <div class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] bg-error opacity-10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[20%] left-[-10%] w-[500px] h-[500px] bg-secondary-container opacity-20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="flex-1 flex items-center justify-center px-margin-mobile md:px-margin-desktop relative z-10">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-24 h-24 bg-error-container rounded-3xl flex items-center justify-center shadow-lg shadow-error/20">
                    <span class="material-symbols-outlined text-on-error-container text-[64px]" style="font-variation-settings: 'FILL' 1;">dns</span>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 rounded-full bg-error-container/20 px-4 py-2 border border-error-container/30 mb-6">
                <span class="material-symbols-outlined text-on-error-container text-[18px]" style="font-variation-settings: 'FILL' 1;">error</span>
                <span class="font-label-md text-label-md text-on-error-container font-semibold">Error 500</span>
            </div>

            <h1 class="font-display-lg text-display-lg text-on-surface mb-4 leading-tight tracking-tight">
                Terjadi <span class="text-error bg-gradient-to-r from-error to-error-container bg-clip-text text-transparent">Kesalahan Server</span>
            </h1>

            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-md mx-auto">
                Maaf, kami mengalami gangguan teknis. Tim kami sedang bekerja untuk memperbaiki masalah ini. Silakan coba lagi nanti.
            </p>

            <div class="flex flex-col gap-4 sm:flex-row justify-center">
                <button onclick="location.reload()" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[20px]">refresh</span>
                    Coba Lagi
                </button>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md text-on-surface border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                    <span class="material-symbols-outlined text-[20px]">home</span>
                    Beranda
                </a>
            </div>

            <div class="mt-12 pt-8 border-t border-outline-variant/30">
                <p class="font-label-sm text-label-sm text-on-surface-variant">
                    Masalah berlanjut? <a href="mailto:support@edumentor.test" class="text-primary hover:underline font-semibold">Laporkan ke Support</a>
                </p>
            </div>
        </div>
    </div>

    <footer class="bg-surface-container-lowest border-t border-outline-variant py-8 relative z-10">
        <div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop text-center">
            <p class="font-label-sm text-label-sm text-on-surface-variant">&copy; {{ date('Y') }} {{ config('app.name', 'EduMentor') }}. All rights reserved.</p>
        </div>
    </footer>
</main>
@endsection