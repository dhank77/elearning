<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EduMentor') }} - Student Dashboard</title>
        @fonts
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden bg-background font-body-md text-on-background antialiased">
        <header class="sticky top-0 z-50 w-full border-b border-outline-variant bg-surface-container-lowest shadow-sm">
            <div class="mx-auto flex h-16 max-w-container-max items-center justify-between px-margin-mobile md:px-margin-desktop">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</a>
                    <nav class="hidden gap-6 md:flex">
                        <a class="flex h-16 cursor-pointer items-center border-b-2 border-primary font-bold text-primary transition-colors" href="#">Courses</a>
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
                        <button class="rounded-full p-2 text-on-surface-variant transition-all hover:bg-surface-container-high" type="button" aria-label="Settings">
                            <span class="material-symbols-outlined">settings</span>
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full p-2 text-on-surface-variant transition-all hover:bg-surface-container-high" type="submit" aria-label="Log out">
                                <span class="material-symbols-outlined">logout</span>
                            </button>
                        </form>
                        <div class="ml-2 h-8 w-8 overflow-hidden rounded-full border border-outline-variant bg-primary-fixed">
                            <img alt="{{ auth()->user()->name }}" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnZaslN1NjpeWqDVJGq64hmaSJ8hWThThdNlcxlUt0EF2w8XJ2G_c-qKCtzd3wnthB8BGlFW4EVX0ohVyTJZDNVX_zd7YxskJHAKgoGt1B-E968Df486qWh9uH4qNpFt6u4yKKVRNu6F9_uiAVT3GSV-kFckYOHjPk4XHbL36u7kyWi1G8PwBPf9AD8gHr8iFAifAELXs1gliI-ezYc9CmxHuVoCLUliHyA4RmBVPy33cgu_mlL3f46Av1PtVNveblOWRqt246FWk">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto flex max-w-container-max">
            <aside class="sticky top-16 hidden h-[calc(100vh-64px)] w-64 flex-col gap-2 border-r border-outline-variant bg-surface p-4 lg:flex">
                <div class="mb-6 px-2">
                    <h2 class="font-headline-md text-headline-md text-primary">Welcome back, {{ auth()->user()->name }}</h2>
                    <p class="text-label-md text-on-surface-variant">Continue your React course</p>
                </div>

                <nav class="flex flex-col gap-1">
                    <a class="flex scale-95 items-center gap-3 rounded-xl bg-primary-container px-4 py-3 font-bold text-on-primary-container transition-all duration-150" href="#">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        <span class="font-label-md text-label-md">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-on-surface-variant transition-all hover:bg-surface-container-high" href="#">
                        <span class="material-symbols-outlined">school</span>
                        <span class="font-label-md text-label-md">All Courses</span>
                    </a>
                    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-on-surface-variant transition-all hover:bg-surface-container-high" href="#">
                        <span class="material-symbols-outlined">assignment</span>
                        <span class="font-label-md text-label-md">Assignments</span>
                    </a>
                    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-on-surface-variant transition-all hover:bg-surface-container-high" href="#">
                        <span class="material-symbols-outlined">grade</span>
                        <span class="font-label-md text-label-md">Grades</span>
                    </a>
                    <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-on-surface-variant transition-all hover:bg-surface-container-high" href="#">
                        <span class="material-symbols-outlined">person</span>
                        <span class="font-label-md text-label-md">Profile</span>
                    </a>
                </nav>

                <div class="mt-auto flex flex-col gap-2 rounded-2xl bg-secondary-container p-4 text-on-secondary-container">
                    <p class="font-bold text-label-md">Unlock Full Access</p>
                    <p class="text-[12px] opacity-90">Get certificates and career coaching.</p>
                    <button class="mt-2 rounded-lg bg-on-secondary-container px-4 py-2 text-label-md font-bold text-on-secondary transition-opacity hover:opacity-90" type="button">
                        Upgrade to Pro
                    </button>
                </div>
            </aside>

            <main class="min-w-0 flex-1 p-margin-mobile md:p-margin-desktop">
                <section class="mb-10">
                    <h1 class="mb-2 font-headline-lg text-headline-lg text-on-surface">Student Dashboard</h1>
                    <p class="max-w-2xl text-body-lg text-on-surface-variant">Your learning journey is 65% complete this month. You're on a 12-day streak! Keep up the momentum.</p>
                </section>

                <div class="grid grid-cols-1 gap-gutter xl:grid-cols-3">
                    <div class="flex flex-col gap-10 xl:col-span-2">
                        <section>
                            <div class="mb-6 flex items-center justify-between gap-4">
                                <h3 class="font-headline-md text-headline-md text-on-surface">In-progress Courses</h3>
                                <a class="text-label-md font-bold text-primary hover:underline" href="#">View All</a>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <article class="bento-card flex flex-col gap-4 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4">
                                    <div class="h-32 overflow-hidden rounded-xl bg-surface-container-high">
                                        <img alt="React Development" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDL2NyJflMmbdpG1ZEUv4XRImVleh5ZuYrH1Wg0LIhyau_HmSERQ-Y_b954Bq19rHG5Kp4X7_QsJWujF93QSFFjmAr92y8gU8uek3DB6bdyhjTEHt63mIBGtDpv8RsZiRiCVAeCTKRGpf3WVLgC8Sm7ScKpaCT5jZ6PmcCO3T79SaBYZpAakIWOv7Yo9YWTUTf9dexGbNCnjUM1KiAZhZxeeuUAwke_VSU513pk1Lt-dkW3ecPJTgoKmdoQpRx6lfLmxBqv0G67Ixo">
                                    </div>
                                    <div>
                                        <span class="rounded-full bg-secondary-container px-3 py-1 text-[12px] font-bold text-on-secondary-container">Development</span>
                                        <h4 class="mt-2 text-body-md font-bold text-on-surface">Advanced React Patterns</h4>
                                        <p class="text-label-md text-on-surface-variant">Module 4: Performance Hooks</p>
                                    </div>
                                    <div class="mt-2">
                                        <div class="mb-2 flex justify-between text-label-md">
                                            <span class="text-on-surface-variant">Progress</span>
                                            <span class="font-bold text-primary">78%</span>
                                        </div>
                                        <div class="h-2 w-full overflow-hidden rounded-full bg-surface-container-high">
                                            <div class="h-full rounded-full bg-secondary" style="width: 78%"></div>
                                        </div>
                                    </div>
                                </article>

                                <article class="bento-card flex flex-col gap-4 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4">
                                    <div class="h-32 overflow-hidden rounded-xl bg-surface-container-high">
                                        <img alt="UI/UX Design" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBHTZwtM73qjZNXNO0d3m5vfiXPqsyTCZAmELBzpIdJ13msg8zmB7HsG6lnwIarHVVeFw_xtz5bLJy9d0XrcGZn6dV3E2P4rymLlNyKlJZB-cU-QOrt9OFOELqPTXUxUqRC6-5SxtBZHkjl_B-LgXoSWywxrONU4M-4ufk3SHn9Tp-1OmMR4yOqNr_PmGG9Ij3jarFNeKA6plXSFeShaU_1kMpBge_G7EBdb0Bc_17pxTzNcg5o6xD3pxLrU6F7hmPUMk5jZMDYakk">
                                    </div>
                                    <div>
                                        <span class="rounded-full bg-primary-fixed px-3 py-1 text-[12px] font-bold text-on-primary-fixed">Design</span>
                                        <h4 class="mt-2 text-body-md font-bold text-on-surface">Mastering Figma Auto-Layout</h4>
                                        <p class="text-label-md text-on-surface-variant">Module 2: Responsive Components</p>
                                    </div>
                                    <div class="mt-2">
                                        <div class="mb-2 flex justify-between text-label-md">
                                            <span class="text-on-surface-variant">Progress</span>
                                            <span class="font-bold text-primary">32%</span>
                                        </div>
                                        <div class="h-2 w-full overflow-hidden rounded-full bg-surface-container-high">
                                            <div class="h-full rounded-full bg-secondary" style="width: 32%"></div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>

                        <section>
                            <div class="mb-6 flex items-center justify-between gap-4">
                                <h3 class="font-headline-md text-headline-md text-on-surface">Recommended for You</h3>
                                <div class="flex gap-2">
                                    <button class="rounded-full border border-outline-variant p-2 transition-colors hover:bg-surface-container-high" type="button" aria-label="Previous recommendation">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <button class="rounded-full border border-outline-variant p-2 transition-colors hover:bg-surface-container-high" type="button" aria-label="Next recommendation">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>
                            </div>

                            <div class="custom-scrollbar flex gap-6 overflow-x-auto pb-4">
                                <article class="bento-card group min-w-[280px] cursor-pointer overflow-hidden rounded-2xl border border-outline-variant bg-surface-container-lowest">
                                    <div class="relative h-40">
                                        <img alt="Team Collaboration" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4g65Hd66dZ6U5v-DVFYWaNemDtNY8cOCPG-jC9Gh0xbOkJbgZvrygIb32gwEPDTvMTCkX1wQQkOlrQoQir_zJY-HDqmM3FnUWGHOJApUDG3-zp4swGsz8vpHQOjrKk8LstK8o6MVH38Rg4SOfIR6h3n82H1j12UPToX_n1jSxtKm89wjJI8KG0IYhwBVMY8s-Su_tqHInptmBOoyP3mNYZ16IO0IZMi4pi1VR0kYqPUYn7ygTIn5B2vQ5PMXVADN8o0_FPN6b1pI">
                                        <div class="absolute inset-0 bg-primary/20 transition-all group-hover:bg-transparent"></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-2 flex items-start justify-between gap-3">
                                            <h4 class="text-body-md font-bold text-on-surface">Agile Project Management</h4>
                                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                                        </div>
                                        <p class="mb-4 text-label-md text-on-surface-variant">Master the frameworks used by top tech teams globally.</p>
                                        <div class="flex items-center justify-between gap-4">
                                            <span class="font-bold text-primary">Free for {{ auth()->user()->name }}</span>
                                            <button class="group flex items-center gap-1 text-label-md font-bold text-primary" type="button">
                                                Preview <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                                            </button>
                                        </div>
                                    </div>
                                </article>

                                <article class="bento-card group min-w-[280px] cursor-pointer overflow-hidden rounded-2xl border border-outline-variant bg-surface-container-lowest">
                                    <div class="relative h-40">
                                        <img alt="Data Science" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBpI5jtVGDSxu_YNZiEz6j3dkxqjiZnFA7eyt0nrya8U0cHj5C_Ct-Glp1kwao7FdSCDsezOqOtdY_jOQwcRHSmHU9lxAl_F6ug4NKuFLr7tVpXJzT-yOOvF4PzMKYcno2phC_dUx8w-5S0y-1HbL4q1yE-lxqhA0OvqWq3Huu19YVefDqda-h4p34N8EwdszHlIwX8dcSo9MNmyZemxChfNqQ7t46ElTPArz2iuxU7MtV_PrxfdLdlT__2beEY_4PSE0uXJEkgK44">
                                        <div class="absolute inset-0 bg-primary/20 transition-all group-hover:bg-transparent"></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-2 flex items-start justify-between gap-3">
                                            <h4 class="text-body-md font-bold text-on-surface">Data Visualisation with Python</h4>
                                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                                        </div>
                                        <p class="mb-4 text-label-md text-on-surface-variant">Turn complex data into beautiful, insightful stories.</p>
                                        <div class="flex items-center justify-between gap-4">
                                            <span class="font-bold text-primary">Trending</span>
                                            <button class="group flex items-center gap-1 text-label-md font-bold text-primary" type="button">
                                                Preview <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>
                    </div>

                    <aside class="flex flex-col gap-gutter">
                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <div class="mb-6 flex items-center justify-between gap-4">
                                <h3 class="font-bold text-body-lg text-on-surface">June 2024</h3>
                                <div class="flex gap-1">
                                    <button class="text-on-surface-variant hover:text-primary" type="button" aria-label="Previous month">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <button class="text-on-surface-variant hover:text-primary" type="button" aria-label="Next month">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-2 grid grid-cols-7 gap-2 text-center text-[12px] font-bold text-on-surface-variant">
                                <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                            </div>
                            <div class="grid grid-cols-7 gap-2">
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">26</div>
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">27</div>
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">28</div>
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">29</div>
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">30</div>
                                <div class="flex h-8 items-center justify-center text-label-md opacity-20">31</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">1</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">2</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">3</div>
                                <div class="relative flex h-8 cursor-pointer items-center justify-center rounded-lg bg-primary text-label-md text-on-primary">
                                    4
                                    <div class="absolute -right-1 -top-1 h-2 w-2 rounded-full bg-secondary"></div>
                                </div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">5</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">6</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">7</div>
                                <div class="flex h-8 cursor-pointer items-center justify-center rounded-lg bg-surface-container-high text-label-md hover:bg-primary-fixed">8</div>
                            </div>

                            <div class="mt-6 border-t border-outline-variant pt-6">
                                <div class="mb-4 flex items-center gap-3">
                                    <div class="h-2 w-2 rounded-full bg-secondary"></div>
                                    <span class="text-label-md font-bold">Today's Focus</span>
                                </div>
                                <div class="rounded-xl border-l-4 border-secondary bg-surface-container-low p-3">
                                    <p class="text-[12px] font-bold text-on-surface">Assignment Due</p>
                                    <p class="text-[12px] text-on-surface-variant">React Patterns: Lab 1</p>
                                    <p class="mt-1 text-[12px] font-bold text-primary">Due in 4 hours</p>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                            <h3 class="mb-6 font-bold text-body-lg text-on-surface">Upcoming Deadlines</h3>
                            <div class="flex flex-col gap-4">
                                <div class="flex gap-4">
                                    <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-2xl bg-error-container text-on-error-container">
                                        <span class="text-[10px] font-bold">JUN</span>
                                        <span class="text-[16px] font-bold">06</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-bold text-label-md">UX Research Quiz</p>
                                        <p class="text-[12px] text-on-surface-variant">Design Thinking Course</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-2xl bg-surface-container-high text-on-surface-variant">
                                        <span class="text-[10px] font-bold">JUN</span>
                                        <span class="text-[16px] font-bold">12</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-bold text-label-md">Capstone Project Draft</p>
                                        <p class="text-[12px] text-on-surface-variant">Mastering React</p>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-6 w-full rounded-xl border border-outline py-3 text-label-md font-bold text-on-surface transition-colors hover:bg-surface-container-low" type="button">
                                View Schedule
                            </button>
                        </section>
                    </aside>
                </div>
            </main>
        </div>

        <footer class="mt-10 w-full border-t border-outline-variant bg-surface-container-highest py-base">
            <div class="mx-auto flex max-w-container-max flex-col items-center justify-between px-margin-mobile py-8 md:flex-row md:px-margin-desktop">
                <div class="mb-4 md:mb-0">
                    <span class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</span>
                    <p class="mt-2 text-label-md text-on-surface-variant">© 2024 {{ config('app.name', 'EduMentor') }} Learning. All rights reserved.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-6">
                    <a class="text-label-md text-on-surface-variant hover:underline" href="#">Privacy Policy</a>
                    <a class="text-label-md text-on-surface-variant hover:underline" href="#">Terms of Service</a>
                    <a class="text-label-md text-on-surface-variant hover:underline" href="#">Help Center</a>
                    <a class="text-label-md text-on-surface-variant hover:underline" href="#">Contact Us</a>
                </div>
            </div>
        </footer>
    </body>
</html>
