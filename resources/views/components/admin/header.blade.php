@props(['placeholder' => 'Cari...', 'showNotifications' => false, 'showAdminLabel' => false])

<header class="fixed left-0 right-0 top-0 z-30 flex h-16 items-center justify-between border-b border-outline-variant bg-surface px-margin-mobile lg:left-64 lg:px-margin-desktop">
    <div class="flex items-center gap-2 w-full max-w-md">
        <button id="sidebar-toggle" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-primary lg:hidden" type="button" aria-label="Toggle Menu">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input class="w-full rounded-full border border-outline-variant bg-surface-container-low py-2 pl-10 pr-4 font-label-md text-label-md transition-colors focus:border-primary focus:outline-none" placeholder="{{ $placeholder }}" type="text">
        </div>
    </div>
    <div class="flex items-center gap-3">
        @if ($showNotifications)
            <button class="rounded-full p-2 text-on-surface-variant transition-colors hover:text-primary" type="button" aria-label="Notifications">
                <span class="material-symbols-outlined">notifications</span>
            </button>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-full p-2 text-on-surface-variant transition-colors hover:text-primary" type="submit" aria-label="Log out">
                <span class="material-symbols-outlined">logout</span>
            </button>
        </form>
        @if ($showAdminLabel)
            <div class="hidden h-8 w-px bg-outline-variant sm:block"></div>
            <p class="hidden font-label-md text-label-md font-bold text-primary sm:block">Admin Panel</p>
        @endif
    </div>
</header>
