@extends('layouts.teacher')

@section('title', config('app.name', 'EduMentor') . ' - Edit Kupon')

@section('content')
    <div class="mx-auto max-w-[1280px] p-margin-mobile md:p-margin-desktop">
        <div class="mb-8">
            <a href="{{ route('teacher.coupons.index') }}" class="mb-4 inline-flex items-center gap-2 font-label-md text-label-md font-bold text-primary">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali ke Daftar Kupon
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Edit Kupon</h1>
            <p class="mt-2 font-body-md text-body-md text-on-surface-variant">Perbarui informasi kupon <strong>{{ $coupon->code }}</strong>.</p>
        </div>

        @include('coupons._form', [
            'coupon' => $coupon,
            'action' => route('teacher.coupons.update', $coupon),
            'method' => 'PUT',
        ])
    </div>
@endsection