@extends('layouts.app')

@section('title', 'Login | ' . config('app.name', 'EduMentor'))
@section('bodyClass', 'flex min-h-screen flex-col bg-background font-body-md text-on-background antialiased')

@section('body')
        <main class="relative flex flex-grow items-center justify-center overflow-hidden p-margin-mobile md:p-margin-desktop">
            <div class="pointer-events-none absolute right-[-10%] top-[-10%] h-[500px] w-[500px] rounded-full bg-primary-fixed opacity-20 blur-[100px]"></div>
            <div class="pointer-events-none absolute bottom-[-5%] left-[-5%] h-[400px] w-[400px] rounded-full bg-secondary-container opacity-20 blur-[80px]"></div>

            <div class="relative z-10 grid w-full max-w-container-max grid-cols-1 overflow-hidden rounded-[32px] border border-outline-variant bg-surface-container-lowest shadow-[0px_4px_40px_rgba(0,0,0,0.06)] lg:grid-cols-2">
                <section class="relative hidden flex-col justify-center overflow-hidden bg-primary-container p-16 lg:flex">
                    <div class="relative z-20">
                        <h1 class="mb-6 font-display-lg text-display-lg font-bold text-on-primary">Unlock Your Potential.</h1>
                        <p class="mb-12 max-w-md font-body-lg text-body-lg text-on-primary-container">
                            Join over 50,000 students worldwide and master the skills of tomorrow with our industry-leading mentors.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <img alt="Student" class="h-10 w-10 rounded-full border-2 border-on-primary object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOAzztqkoqk38kK4XnnWWclvgfP9zQ88V7GPw9_X36HvXG4LrnvSG3-Y0eufrIeU_gLFlIdj-bpgCVP-xOfY2GGHllg1bc65gyRU1BGG0V89bR9NjRMzOL_IZJWTl36zulCTs9DV7qmvi8i4yKZb7fD4IfkkC6JHfLDqD6JWwhXh6fC8j6Yg1Lvu00unKk3nXhFQeqC96ZViRWXd10RK8IB7nKQznlqom2wu5U_lG6t4o4icnJWzKisk8HWdBXZ0sRk8zNLeHZVQw">
                                <img alt="Student" class="h-10 w-10 rounded-full border-2 border-on-primary object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMfGrlsf0Rhg5yFLxS0P-klE3F-6SwfmCxYMQjqOQDoaIdq7b-IeIvF76UXGbtr59u6Y9KdjAKfsX7jzXZAwdnpqIfoAlYJCgv0RJySfb9W9lMNE2_-YkAc7hvx_dMDcibN-uviSNjG1ADJtQwd3Z44gbQXwQdn4ybUdFsDJfYCTbyq2JSl3jevRFZqYa6UBQ8uj-0Z3-SHV9z1o7yaGqqWFfSbxGmvBFzQYIhXOaVxvFKUzWcEJHlVBIjYWf_-oXS_nexUd-dqNM">
                                <img alt="Student" class="h-10 w-10 rounded-full border-2 border-on-primary object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgMl-k2Xr7Tu0RfCRZZHsBVBmWsITzg8PUvhOb-DlONVhE96qgWqNkubT3sNhQfocTj-qGJj4L__VviZ-90_biG57IlDtRRKQX05hsJratt73y7MV46ZKWnd1irgaFxecqyJxKqgcZy6MDknIPmji1GYdQfR8NkGgf1osJAFtwyfZkkfxnWTo4bmnye-YscbzNjAqp0m09ZbowlAilGYUIJbeMTZ2q16mQwtaCETwkNUvFz9bxaagleP8lY-N9QTASCrF6v1QVuhA">
                            </div>
                            <span class="font-label-md text-label-md text-on-primary">Joined by 12k+ this month</span>
                        </div>
                    </div>

                    <div class="pointer-events-none absolute bottom-0 right-0 flex h-full w-full items-end justify-end p-8 opacity-10">
                        <span class="material-symbols-outlined translate-x-32 translate-y-32 text-[400px] text-on-primary" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                </section>

                <section class="flex flex-col justify-center p-8 md:p-16">
                    <div class="mb-10">
                        <a href="{{ url('/') }}" class="mb-8 flex items-center gap-2">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-on-primary">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                            </span>
                            <span class="font-headline-md text-headline-md text-primary">{{ config('app.name', 'EduMentor') }}</span>
                        </a>
                        <h2 class="mb-2 font-headline-lg text-headline-lg text-on-surface md:text-headline-lg-mobile lg:text-headline-lg">Welcome Back</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Please enter your details to access your learning dashboard.</p>
                    </div>

<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 rounded-xl border border-outline-variant px-6 py-3 transition-all duration-200 hover:bg-surface-container-low active:scale-95">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.64l-3.57-2.77c-1.01.69-2.39 1.1-3.71 1.1-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                <path d="M5.84 14.16c-.22-.66-.35-1.36-.35-2.08s.13-1.42.35-2.08V7.16H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.84l3.66-2.84z" fill="#FBBC05"></path>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.16l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                            </svg>
                            <span class="font-label-md text-label-md text-on-surface">Google</span>
                        </a>
                    </div>

                    <div class="relative mb-8 flex items-center">
                        <div class="grow border-t border-outline-variant"></div>
                        <span class="mx-4 shrink-0 font-label-md text-label-md uppercase text-outline">or email</span>
                        <div class="grow border-t border-outline-variant"></div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="email" class="ml-1 block font-label-md text-label-md text-on-surface-variant">Email Address</label>
                            <div class="group relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline transition-colors group-focus-within:text-primary">mail</span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="alex@example.com" class="w-full rounded-xl border border-outline-variant bg-surface py-4 pl-12 pr-4 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                            @error('email')
                                <p class="ml-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="ml-1 block font-label-md text-label-md text-on-surface-variant">Password</label>
                            <div class="group relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline transition-colors group-focus-within:text-primary">lock</span>
                                <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••" class="w-full rounded-xl border border-outline-variant bg-surface py-4 pl-12 pr-12 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/20">
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline transition-colors hover:text-on-surface" type="button" data-password-toggle="password" aria-label="Toggle password visibility">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="ml-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="captcha" class="ml-1 block font-label-md text-label-md text-on-surface-variant">Verification Code</label>
                            <div class="flex items-center gap-4">
                                <div class="flex shrink-0 items-center overflow-hidden rounded-xl border border-outline-variant bg-surface-container-low">
                                    <img src="{!! captcha_src('flat') !!}" alt="captcha" id="captcha-img" class="h-[45px] w-[120px] object-cover">
                                    <button type="button" onclick="refreshCaptcha()" class="flex h-[45px] w-[45px] items-center justify-center border-l border-outline-variant text-outline transition-colors hover:text-primary" aria-label="Refresh Captcha">
                                        <span class="material-symbols-outlined text-[20px]">refresh</span>
                                    </button>
                                </div>
                                <input id="captcha" name="captcha" type="text" required placeholder="3-digit code" class="w-full rounded-xl border border-outline-variant bg-surface py-3 px-4 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                            @error('captcha')
                                <p class="ml-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between gap-4 py-1">
                            <label for="remember" class="group flex cursor-pointer items-center gap-2">
                                <span class="relative flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="peer h-5 w-5 appearance-none rounded border-2 border-outline-variant bg-surface transition-all checked:border-primary checked:bg-primary">
                                    <span class="material-symbols-outlined absolute left-1/2 top-1/2 text-[16px] font-bold text-on-primary opacity-0 -translate-x-1/2 -translate-y-1/2 peer-checked:opacity-100" style="font-variation-settings: 'wght' 700;">check</span>
                                </span>
                                <span class="font-label-md text-label-md text-on-surface-variant transition-colors group-hover:text-on-surface">Remember me</span>
                            </label>
                            <a class="font-label-md text-label-md font-bold text-primary hover:underline" href="#">Forgot password?</a>
                        </div>

                        <button class="mt-2 w-full rounded-xl bg-primary py-4 font-bold text-on-primary shadow-lg shadow-primary/20 transition-all duration-300 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 active:scale-[0.98]" type="submit">
                            Sign In
                        </button>
                    </form>

                    <p class="mt-8 text-center font-body-md text-body-md text-on-surface-variant">
                        Don't have an account?
                        <a class="font-bold text-secondary hover:underline" href="{{ route('register') }}">Create an account</a>
                    </p>
                </section>
            </div>
        </main>

        <x-shared.footer variant="contained" />

        <script>
            function refreshCaptcha() {
                const img = document.getElementById('captcha-img');
                if (img) {
                    img.src = '{{ url('captcha/flat') }}?' + Math.random();
                }
            }
        </script>
@endsection
