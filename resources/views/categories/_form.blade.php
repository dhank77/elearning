<section class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm md:p-8">
    <form method="POST" action="{{ $action }}" class="space-y-6">
        @csrf
        @isset($method)
            @method($method)
        @endisset

        <div>
            <label for="name" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Nama Kategori</label>
            <input id="name" type="text" name="name" value="{{ old('name', $category?->name) }}" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan nama kategori">
            @error('name')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block font-label-md text-label-md font-bold text-on-surface">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-outline-variant bg-white px-4 py-3 font-body-md text-body-md text-on-surface transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category?->description) }}</textarea>
            @error('description')
                <p class="mt-2 font-label-md text-label-md text-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-label-md text-label-md font-bold text-on-primary transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Simpan
            </button>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center rounded-lg border border-outline-variant px-6 py-3 font-label-md text-label-md font-bold text-on-surface-variant transition hover:bg-surface-container-low">Batal</a>
        </div>
    </form>
</section>
