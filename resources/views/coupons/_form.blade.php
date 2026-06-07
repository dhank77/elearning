<section class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm md:p-8">
    <form method="POST" action="{{ $action }}" class="space-y-6">
        @csrf
        @isset($method)
            @method($method)
        @endisset

        <div>
            <label for="code" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Kode Kupon</label>
            <input id="code" type="text" name="code" value="{{ old('code', $coupon?->code) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan kode kupon (e.g. DISKON50)">
            @error('code')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="discount_percentage" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Persentase Diskon</label>
            <input id="discount_percentage" type="number" name="discount_percentage" value="{{ old('discount_percentage', $coupon?->discount_percentage) }}" min="0" max="100" step="0.01" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan persentase diskon (0-100)">
            @error('discount_percentage')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan deskripsi kupon (opsional)">{{ old('description', $coupon?->description) }}</textarea>
            @error('description')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expires_at" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Berlaku Sampai</label>
            <input id="expires_at" type="date" name="expires_at" value="{{ old('expires_at', $coupon?->expires_at?->format('Y-m-d')) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Tanggal berakhir kupon (opsional)">
            @error('expires_at')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon?->is_active ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-outline-variant text-primary accent-primary">
            <label for="is_active" class="font-label-md text-label-md font-bold text-on-surface">Aktif</label>
            @error('is_active')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Simpan
            </button>
            <a href="{{ route('coupons.index') }}" class="inline-flex items-center justify-center rounded-lg border border-outline-variant px-6 py-3 font-label-md text-label-md font-bold text-on-surface-variant transition hover:bg-surface-container-low">Batal</a>
        </div>
    </form>
</section>