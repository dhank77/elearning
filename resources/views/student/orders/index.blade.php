@extends('layouts.app')

@section('title', config('app.name', 'EduMentor') . ' - Riwayat Order')
@section('bodyClass', 'bg-background font-body-md text-on-surface antialiased')

@section('body')
        <x-admin.sidebar active="orders" />

        <x-admin.header placeholder="Cari order..." />

        <main class="min-h-screen pt-16 lg:ml-64">
            <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
                <div class="mb-8">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Order Saya</h1>
                    <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Lihat riwayat pembelian kursus dan status pembayaran Anda.</p>
                </div>

                <section class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="flex items-center justify-between border-b border-outline-variant bg-surface-bright px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-label-md text-label-md font-bold">Riwayat Pembayaran</span>
                            <span class="rounded bg-surface-container-high px-2 py-0.5 text-[12px] font-bold">{{ $orders->total() }} Transaksi</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Kursus</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">No. Order</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Total</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Metode</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Status</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Tanggal</th>
                                    <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                @foreach ($orders as $order)
                                    <tr class="transition-colors hover:bg-surface-container-lowest">
                                        <td class="px-6 py-4 font-body-md text-body-md font-medium text-on-surface">
                                            {{ $order->course?->title ?? 'Kursus Terhapus' }}
                                        </td>
                                        <td class="px-6 py-4 font-mono text-[13px] text-on-surface-variant">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 font-body-md text-body-md font-medium text-on-surface">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">
                                            @if ($order->payment_method === 'xendit')
                                                Xendit
                                            @elseif ($order->payment_method === 'free')
                                                Gratis
                                            @else
                                                Transfer Manual
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($order->status === 'paid')
                                                <span class="inline-flex items-center rounded-full bg-success-container px-2.5 py-0.5 text-[12px] font-bold text-on-success-container">Berhasil</span>
                                            @elseif ($order->status === 'pending')
                                                <span class="inline-flex items-center rounded-full bg-warning-container px-2.5 py-0.5 text-[12px] font-bold text-on-warning-container">Menunggu</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-error-container px-2.5 py-0.5 text-[12px] font-bold text-on-error-container">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($order->status === 'pending')
                                                <a href="{{ route('checkout.pay', $order) }}" class="inline-flex items-center gap-1 rounded bg-primary px-3 py-1.5 text-[12px] font-bold text-on-primary transition-opacity hover:opacity-90">
                                                    Bayar
                                                </a>
                                            @else
                                                <span class="text-on-surface-variant text-[12px]">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($orders->isEmpty())
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center font-label-md text-label-md text-on-surface-variant">Anda belum memiliki riwayat transaksi.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($orders->hasPages())
                        <div class="flex items-center justify-between border-t border-outline-variant px-6 py-4">
                            <p class="font-label-md text-label-md text-on-surface-variant">Menampilkan {{ $orders->firstItem() }}-{{ $orders->lastItem() }} dari {{ $orders->total() }} order</p>
                            <div class="flex gap-2">
                                @if ($orders->onFirstPage())
                                    <span class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md text-on-surface-variant opacity-50">Prev</span>
                                @else
                                    <a href="{{ $orders->previousPageUrl() }}" class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md transition-colors hover:bg-surface-container-low">Prev</a>
                                @endif

                                @if ($orders->hasMorePages())
                                    <a href="{{ $orders->nextPageUrl() }}" class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary transition-opacity hover:opacity-90">Next</a>
                                @else
                                    <span class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary opacity-50">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </main>
@endsection
