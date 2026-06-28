@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name', 'EduMentor'))
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
        </header>

        {{-- Checkout Content --}}
        <section class="mx-auto max-w-container-max w-full px-margin-mobile md:px-margin-desktop py-10 flex-1">
            <div class="max-w-2xl mx-auto">
                <h1 class="font-headline-lg text-headline-lg text-on-surface mb-8">Checkout</h1>

                {{-- Order Summary --}}
                <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 mb-6">
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-4">Ringkasan Pesanan</h2>

                    <div class="flex gap-4 mb-4">
                        <div class="w-24 aspect-video rounded-lg overflow-hidden bg-surface-container flex-shrink-0">
                            @if ($order->course->cover_image_path)
                                <img src="{{ asset('storage/' . $order->course->cover_image_path) }}" alt="{{ $order->course->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-on-surface-variant/30 text-[32px]">menu_book</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-label-lg text-label-lg text-on-surface mb-1">{{ $order->course->title }}</h3>
                            <p class="font-label-md text-label-md text-on-surface-variant">oleh {{ $order->course->teacher->name }}</p>
                        </div>
                    </div>

                    {{-- Coupon Form --}}
                    @if ($order->status === 'pending')
                        <div class="border-t border-outline-variant py-4">
                            @if (session('success'))
                                <div class="mb-4 rounded-lg bg-secondary-container/30 border border-secondary px-4 py-2 text-label-md text-secondary font-bold">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('checkout.apply-coupon', $order) }}" method="POST" class="flex gap-2">
                                @csrf
                                <div class="flex-1">
                                    <input type="text" name="coupon_code" placeholder="Masukkan kode kupon (e.g. DISKON50)" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-body-md text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" value="{{ old('coupon_code') }}">
                                    @error('coupon_code')
                                        <p class="mt-1 text-[12px] text-error font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="rounded-lg bg-secondary px-4 py-2 font-label-md text-label-md font-bold text-on-secondary hover:bg-secondary-container transition-all active:scale-95">
                                    Terapkan
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="border-t border-outline-variant pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-body-md text-body-md text-on-surface-variant">Nomor Pesanan</span>
                            <span class="font-label-md text-label-md text-on-surface font-mono">{{ $order->order_number }}</span>
                        </div>
                        @if ($order->amount < $order->course->price)
                            <div class="flex justify-between items-center mt-2">
                                <span class="font-body-md text-body-md text-on-surface-variant">Harga Asli</span>
                                <span class="font-label-md text-label-md text-on-surface-variant line-through">Rp {{ number_format($order->course->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="font-body-md text-body-md text-on-surface-variant font-medium">Potongan Kupon</span>
                                <span class="font-label-md text-label-md text-secondary font-bold">- Rp {{ number_format($order->course->price - $order->amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-body-md text-body-md text-on-surface-variant">Total Pembayaran</span>
                            <span class="font-headline-sm text-headline-sm text-primary font-bold">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-body-md text-body-md text-on-surface-variant">Metode Pembayaran</span>
                            <span class="font-label-md text-label-md text-on-surface font-bold">{{ $order->payment_method === 'xendit' ? 'Xendit' : 'Transfer Bank Manual' }}</span>
                        </div>
                    </div>
                </div>

                @if ($order->payment_method === 'xendit')
                    {{-- Xendit Payment --}}
                    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 mb-6">
                        <h2 class="font-headline-md text-headline-md text-on-surface mb-4">Pembayaran via Xendit</h2>

                        <div class="space-y-4 font-body-md text-body-md text-on-surface-variant">
                            <p>Anda akan dialihkan ke halaman pembayaran Xendit untuk menyelesaikan pembayaran.</p>
                            <div class="rounded-lg bg-primary-container/50 p-4 border border-primary">
                                <p class="text-primary">
                                    <span class="material-symbols-outlined text-[18px] align-middle mr-1">info</span>
                                    Klik tombol "Bayar Sekarang" di bawah untuk melanjutkan ke halaman pembayaran.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <div class="flex gap-3">
                        <a href="{{ route('welcome') }}" class="flex-1 inline-flex items-center justify-center rounded-xl px-6 py-4 font-label-md text-label-md text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                            Batal
                        </a>
                        <a href="{{ route('checkout.pay', $order) }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 font-label-md text-label-md bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container transition-all duration-300 active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">payments</span>
                            Bayar Sekarang
                        </a>
                    </div>
                @else
                    {{-- Manual Bank Transfer --}}
                    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 mb-6">
                        <h2 class="font-headline-md text-headline-md text-on-surface mb-4">Instruksi Pembayaran</h2>

                        <div class="space-y-3 font-body-md text-body-md text-on-surface-variant">
                            <p>Silakan transfer ke rekening berikut:</p>
                            <div class="rounded-lg bg-surface-container p-4 border border-outline-variant">
                                <p class="font-bold text-on-surface">Bank: <span class="font-normal">BCA</span></p>
                                <p class="font-bold text-on-surface mt-1">No. Rekening: <span class="font-normal">1234567890</span></p>
                                <p class="font-bold text-on-surface mt-1">Atas Nama: <span class="font-normal">EduMentor</span></p>
                            </div>
                            <p class="text-amber-600">
                                <span class="material-symbols-outlined text-[18px] align-middle mr-1">info</span>
                                Setelah melakukan transfer, hubungi admin untuk konfirmasi pembayaran.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('welcome') }}" class="flex-1 inline-flex items-center justify-center rounded-xl px-6 py-4 font-label-md text-label-md text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-200">
                            Kembali
                        </a>
                    </div>
                @endif
            </div>
        </section>

        {{-- Footer --}}
        <x-shared.footer />
    </main>
@endsection
