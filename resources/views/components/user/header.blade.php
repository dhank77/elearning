<header class="sticky top-0 z-50 w-full border-b border-outline-variant bg-surface-container-lowest shadow-sm">
    <div class="mx-auto flex h-16 max-w-container-max items-center justify-between px-margin-mobile md:px-margin-desktop">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</a>
            <nav class="hidden gap-6 md:flex">
                <a class="flex h-16 cursor-pointer items-center text-on-surface-variant transition-colors hover:text-primary" href="#">Courses</a>
                <a class="flex h-16 cursor-pointer items-center text-on-surface-variant transition-colors hover:text-primary" href="#">My Learning</a>
                <a class="flex h-16 cursor-pointer items-center text-on-surface-variant transition-colors hover:text-primary" href="#">Resources</a>
            </nav>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-64 rounded-full border border-outline-variant bg-surface-container-low py-2 pl-10 pr-4 text-label-md focus:border-primary focus:outline-none" placeholder="Search courses..." type="text">
            </div>
            <div class="flex items-center gap-2">
                <button class="rounded-full p-2 text-on-surface-variant transition-all hover:bg-surface-container-high" type="button" aria-label="Notifications">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <details class="group relative ml-2">
                    <summary class="flex cursor-pointer list-none items-center rounded-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:ring-offset-2 focus:ring-offset-surface-container-lowest [&::-webkit-details-marker]:hidden" aria-label="Open account menu">
                        <span class="h-8 w-8 overflow-hidden rounded-full border border-outline-variant bg-primary-fixed transition-all group-open:ring-2 group-open:ring-primary/20">
                            <img alt="{{ auth()->user()->name }}" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnZaslN1NjpeWqDVJGq64hmaSJ8hWThThdNlcxlUt0EF2w8XJ2G_c-qKCtzd3wnthB8BGlFW4EVX0ohVyTJZDNVX_zd7YxskJHAKgoGt1B-E968Df486qWh9uH4qNpFt6u4yKKVRNu6F9_uiAVT3GSV-kFckYOHjPk4XHbL36u7kyWi1G8PwBPf9AD8gHr8iFAifAELXs1gliI-ezYc9CmxHuVoCLUliHyA4RmBVPy33cgu_mlL3f46Av1PtVNveblOWRqt246FWk">
                        </span>
                    </summary>

                    <div class="absolute right-0 top-full z-50 mt-3 w-64 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest py-2 shadow-lg shadow-on-surface/5">
                        <div class="border-b border-outline-variant px-4 py-3">
                            <p class="truncate font-label-md text-label-md font-bold text-on-surface">{{ auth()->user()->name }}</p>
                            <p class="truncate text-[12px] text-on-surface-variant">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary">
                            <span class="material-symbols-outlined text-[20px]">account_circle</span>
                            Profil
                        </a>
                        <a href="{{ route('profile.password.edit') }}" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary">
                            <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                            Ubah Password
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="flex w-full items-center gap-3 px-4 py-3 text-left font-label-md text-label-md text-error transition-colors hover:bg-error-container/30" type="submit">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>
