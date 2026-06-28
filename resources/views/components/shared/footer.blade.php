@props([
    'variant' => 'default',
    'showBrand' => false,
    'showContact' => false,
])

@php
    $footerClass = match ($variant) {
        'band' => 'w-full border-t border-outline-variant bg-surface-container-highest py-base',
        'contained' => 'mx-auto flex w-full max-w-container-max flex-col items-center justify-between gap-4 border-t border-outline-variant px-margin-mobile py-8 md:flex-row md:px-margin-desktop',
        default => 'w-full py-8 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto border-t border-outline-variant flex flex-col md:flex-row justify-between items-center gap-4 relative z-10',
    };
@endphp

@if ($variant === 'band')
    <footer {{ $attributes->class([$footerClass]) }}>
        <div class="mx-auto flex max-w-container-max flex-col items-center justify-between gap-4 px-margin-mobile py-8 md:flex-row md:px-margin-desktop">
            @if ($showBrand)
                <div class="mb-4 md:mb-0">
                    <span class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</span>
                    <p class="mt-2 text-label-md text-on-surface-variant">&copy; {{ now()->year }} {{ config('app.name', 'EduMentor') }} Learning. All rights reserved.</p>
                </div>
            @else
                <div class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</div>
            @endif

            <x-shared.footer-links :show-contact="$showContact" />

            @unless ($showBrand)
                <p class="font-label-md text-label-md text-on-surface-variant">&copy; {{ now()->year }} {{ config('app.name', 'EduMentor') }} Learning. All rights reserved.</p>
            @endunless
        </div>
    </footer>
@else
    <footer {{ $attributes->class([$footerClass]) }}>
        <p class="font-label-md text-label-md text-on-surface-variant">&copy; {{ now()->year }} {{ config('app.name', 'EduMentor') }}{{ $variant === 'contained' ? ' Learning' : '' }}. All rights reserved.</p>
        <x-shared.footer-links :show-contact="$showContact" />
    </footer>
@endif

