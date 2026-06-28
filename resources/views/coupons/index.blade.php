@extends('layouts.teacher')

@section('title', config('app.name', 'EduMentor') . ' - Master Kupon')

@section('content')
    <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
        <div class="mb-8 flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Manajemen Kupon</h2>
                <p class="mt-1 font-body-md text-body-md text-on-surface-variant">Kelola kupon diskon dan kode promo untuk kursus Anda.</p>
            </div>
            <a href="{{ route('teacher.coupons.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary shadow-lg shadow-primary/10 transition-all hover:scale-[1.02] hover:shadow-primary/20 active:scale-95">
                <span class="material-symbols-outlined">add</span>
                Tambah Kupon
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-secondary-container bg-secondary-container/30 px-6 py-4 font-label-md text-label-md text-on-secondary-container">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8 grid grid-cols-1 gap-gutter md:grid-cols-3">
            <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-container/10 text-primary">
                    <span class="material-symbols-outlined">sell</span>
                </div>
                <div>
                    <p class="font-label-md text-[12px] text-on-surface-variant">Total Kupon</p>
                    <p class="font-headline-md text-headline-md">{{ $coupons->total() }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary-container/30 text-secondary">
                    <span class="material-symbols-outlined">confirmation_number</span>
                </div>
                <div>
                    <p class="font-label-md text-[12px] text-on-surface-variant">Kupon Halaman Ini</p>
                    <p class="font-headline-md text-headline-md">{{ $coupons->count() }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-tertiary-fixed-dim/20 text-on-tertiary-fixed-variant">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <p class="font-label-md text-[12px] text-on-surface-variant">Status Sistem</p>
                    <p class="font-headline-md text-headline-md">Aktif</p>
                </div>
            </div>
        </div>

        <section class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <div class="flex items-center justify-between border-b border-outline-variant bg-surface-bright px-6 py-4">
                <div class="flex items-center gap-3">
                    <span class="font-label-md text-label-md font-bold">Daftar Kupon</span>
                    <span class="rounded bg-surface-container-high px-2 py-0.5 text-[12px] font-bold">{{ $coupons->total() }} Items</span>
                </div>
                <div class="flex items-center gap-2">
                    <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container" type="button" aria-label="Filter">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    </button>
                    <button class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container" type="button" aria-label="Download">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Kode Kupon</th>
                            <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Kursus</th>
                            <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Diskon</th>
                            <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Deskripsi</th>
                            <th class="border-b border-outline-variant px-6 py-4 font-label-md text-label-md text-on-surface-variant">Berlaku Sampai</th>
                            <th class="border-b border-outline-variant px-6 py-4 text-center font-label-md text-label-md text-on-surface-variant">Status</th>
                            <th class="border-b border-outline-variant px-6 py-4 text-right font-label-md text-label-md text-on-surface-variant">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @foreach ($coupons as $coupon)
                            <tr class="transition-colors hover:bg-surface-container-lowest">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                            <span class="material-symbols-outlined text-[18px]">sell</span>
                                        </div>
                                        <span class="font-body-md text-body-md font-medium">{{ $coupon->code }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-body-md text-body-md font-medium text-on-surface">
                                        {{ $coupon->courses->pluck('title')->implode(', ') ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-body-md text-body-md font-bold text-secondary">{{ (int) $coupon->discount_percentage }}%</span>
                                </td>
                                <td class="max-w-md px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $coupon->description ?? '-' }}</td>
                                <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">{{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Tanpa batas' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($coupon->is_active)
                                        <span class="rounded-full bg-secondary-container/30 px-3 py-1 text-[12px] font-bold text-secondary">Active</span>
                                    @else
                                        <span class="rounded-full bg-error-container/30 px-3 py-1 text-[12px] font-bold text-error">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('teacher.coupons.edit', $coupon) }}" class="rounded-lg p-2 text-primary transition-colors hover:bg-surface-container" aria-label="Edit {{ $coupon->code }}">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('teacher.coupons.destroy', $coupon) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg p-2 text-error transition-colors hover:bg-error-container/30" onclick="return confirm('Yakin ingin menghapus kupon ini?')" aria-label="Hapus {{ $coupon->code }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($coupons->isEmpty())
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center font-label-md text-label-md text-on-surface-variant">Belum ada kupon yang ditambahkan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($coupons->hasPages())
                <div class="flex items-center justify-between border-t border-outline-variant px-6 py-4">
                    <p class="font-label-md text-label-md text-on-surface-variant">Menampilkan {{ $coupons->firstItem() }}-{{ $coupons->lastItem() }} dari {{ $coupons->total() }} kupon</p>
                    <div class="flex gap-2">
                        @if ($coupons->onFirstPage())
                            <span class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md text-on-surface-variant opacity-50">Previous</span>
                        @else
                            <a href="{{ $coupons->previousPageUrl() }}" class="rounded-lg border border-outline-variant px-4 py-2 font-label-md text-label-md transition-colors hover:bg-surface-container-low">Previous</a>
                        @endif

                        @if ($coupons->hasMorePages())
                            <a href="{{ $coupons->nextPageUrl() }}" class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary transition-opacity hover:opacity-90">Next</a>
                        @else
                            <span class="rounded-lg bg-primary px-4 py-2 font-label-md text-label-md text-on-primary opacity-50">Next</span>
                        @endif
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection