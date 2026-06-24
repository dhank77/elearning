@extends('layouts.app')

@section('title', 'Join ' . config('app.name', 'EduMentor') . ' - Start Your Learning Journey')
@section('bodyClass', 'flex min-h-screen flex-col bg-background font-body-md text-on-background antialiased')

@section('body')
        <header class="sticky top-0 z-50 w-full border-b border-outline-variant bg-surface-container-lowest shadow-sm">
            <div class="mx-auto flex h-16 max-w-container-max items-center justify-between px-margin-mobile md:px-margin-desktop">
                <a href="{{ url('/') }}" class="font-headline-md text-headline-md text-primary">
                    {{ config('app.name', 'EduMentor') }}
                </a>
                <div class="flex items-center gap-4">
                    <span class="hidden font-label-md text-label-md text-on-surface-variant md:inline">Already have an account?</span>
                    <a class="font-label-md text-label-md font-bold text-primary hover:underline" href="{{ route('login') }}">Log In</a>
                </div>
            </div>
        </header>

        <main class="flex flex-grow items-center justify-center px-margin-mobile py-12 md:px-margin-desktop">
            <div class="grid w-full max-w-container-max grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <section class="hidden flex-col gap-8 pr-gutter lg:flex">
                    <div>
                        <h1 class="mb-4 font-display-lg text-display-lg font-bold text-primary">Start your journey to mastery today.</h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant">Join over 50,000 students worldwide and gain access to expert-led courses designed to help you succeed in your career.</p>
                    </div>

                    <div class="form-shadow relative aspect-video overflow-hidden rounded-xl">
                        <img alt="Students collaborating" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUiIP_0IsLzjyeH2-fw-lzWRWMsGYTP1osjkIi6iNoq-4F0m-l79FEOy6Mv0UN6lfMqnVT58KcGIFsg0nLOz_2otCqEIQBe7SVvTtVESpbZXYtE-mL273DDZSd00yD2iGVotH-Q-m4uvL4jdVk3oShHph534mQ2ywlEgoPPWjQrlGqjviMUv-IK49Zstg6Xr3n4ar5-nv5n3f6m8XSxarTicStxaUeue9eF1cXOvTNRfKjGYw_QJyqAZE5PbCW2P_fVJ8lK2iQUQI">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 rounded-xl border border-outline-variant bg-surface-container p-4">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                            <div>
                                <p class="font-label-md text-label-md font-bold text-on-surface">Certified Learning</p>
                                <p class="text-sm text-on-surface-variant">Industry recognized certificates.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 rounded-xl border border-outline-variant bg-surface-container p-4">
                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">group</span>
                            <div>
                                <p class="font-label-md text-label-md font-bold text-on-surface">Active Community</p>
                                <p class="text-sm text-on-surface-variant">Learn with peers globally.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-lg">
                    <div class="form-shadow rounded-[1.5rem] border border-outline-variant bg-surface-container-lowest p-8 md:p-10">
                        <div class="mb-8">
                            <h2 class="mb-2 font-headline-lg text-headline-lg text-on-surface">Create Account</h2>
                            <p class="font-body-md text-body-md text-on-surface-variant">Enter your details to get started with your learning path.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                            @csrf

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface">Daftar Sebagai</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex cursor-pointer items-center justify-between rounded-xl border border-outline bg-surface p-4 transition-all hover:border-primary has-[:checked]:border-primary has-[:checked]:ring-1 has-[:checked]:ring-primary">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-primary">school</span>
                                            <div class="text-left">
                                                <p class="font-label-md text-label-md font-bold text-on-surface">Siswa</p>
                                                <p class="text-[11px] text-on-surface-variant">Belajar materi & kelas</p>
                                            </div>
                                        </div>
                                        <input type="radio" name="role" value="user" class="h-4 w-4 text-primary focus:ring-primary" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                                    </label>
                                    <label class="flex cursor-pointer items-center justify-between rounded-xl border border-outline bg-surface p-4 transition-all hover:border-primary has-[:checked]:border-primary has-[:checked]:ring-1 has-[:checked]:ring-primary">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-secondary">co_present</span>
                                            <div class="text-left">
                                                <p class="font-label-md text-label-md font-bold text-on-surface">Pengajar</p>
                                                <p class="text-[11px] text-on-surface-variant">Buat & kelola kelas</p>
                                            </div>
                                        </div>
                                        <input type="radio" name="role" value="teacher" class="h-4 w-4 text-primary focus:ring-primary" {{ old('role') === 'teacher' ? 'checked' : '' }}>
                                    </label>
                                </div>
                                @error('role')
                                    <p class="ml-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface" for="name">Full Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="John Doe" required autofocus autocomplete="name" class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 outline-none transition-all focus:border-primary focus:ring-1 focus:ring-primary">
                                @error('name')
                                    <p class="ml-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface" for="email">Email Address</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="john@example.com" required autocomplete="email" class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 outline-none transition-all focus:border-primary focus:ring-1 focus:ring-primary">
                                @error('email')
                                    <p class="ml-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface" for="password">Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" placeholder="••••••••" required autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 pr-12 outline-none transition-all focus:border-primary focus:ring-1 focus:ring-primary">
                                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant transition-colors hover:text-primary" type="button" data-password-toggle="password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </div>
                                <p class="ml-1 text-[12px] text-on-surface-variant">Must be at least 6 characters long.</p>
                                @error('password')
                                    <p class="ml-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface" for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" required autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 outline-none transition-all focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="ml-1 font-label-md text-label-md text-on-surface" for="captcha">Verification Code</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex shrink-0 items-center overflow-hidden rounded-xl border border-outline-variant bg-surface-container-low">
                                        <img src="{!! captcha_src('flat') !!}" alt="captcha" id="captcha-img" class="h-[45px] w-[120px] object-cover">
                                        <button type="button" onclick="refreshCaptcha()" class="flex h-[45px] w-[45px] items-center justify-center border-l border-outline-variant text-on-surface-variant transition-colors hover:text-primary" aria-label="Refresh Captcha">
                                            <span class="material-symbols-outlined text-[20px]">refresh</span>
                                        </button>
                                    </div>
                                    <input id="captcha" name="captcha" type="text" required placeholder="3-digit code" class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 outline-none transition-all focus:border-primary focus:ring-1 focus:ring-primary">
                                </div>
                                @error('captcha')
                                    <p class="ml-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="flex items-start gap-3 py-2 font-label-md text-label-md text-on-surface-variant" for="terms">
                                <input id="terms" name="terms" type="checkbox" required class="mt-1 h-5 w-5 cursor-pointer rounded border-outline-variant text-primary focus:ring-primary">
                                <span>I agree to the <a class="text-primary hover:underline" href="#">Terms of Service</a> and <a class="text-primary hover:underline" href="#">Privacy Policy</a>.</span>
                            </label>

                            <button class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-4 font-bold text-on-primary shadow-md transition-all hover:bg-primary-container active:scale-[0.98]" type="submit">
                                Sign Up
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </form>

                        <div class="mt-8 border-t border-outline-variant pt-8">
                            <p class="mb-4 text-center text-sm text-on-surface-variant">Or sign up with</p>
                            <a id="google-signup-link" href="{{ route('auth.google') }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant py-3 transition-colors hover:bg-surface-container-low">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.64l-3.57-2.77c-1.01.69-2.39 1.1-3.71 1.1-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                    <path d="M5.84 14.16c-.22-.66-.35-1.36-.35-2.08s.13-1.42.35-2.08V7.16H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.84l3.66-2.84z" fill="#FBBC05"></path>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.16l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                                </svg>
                                <span class="font-label-md text-label-md">Google</span>
                            </a>
                        </div>
                    </div>

                    <p class="mt-8 text-center font-body-md text-on-surface-variant lg:hidden">
                        You're just one step away from joining our vibrant community of learners!
                    </p>
                </section>
            </div>
        </main>

        <x-shared.footer variant="band" show-contact />

        <script>
            function refreshCaptcha() {
                const img = document.getElementById('captcha-img');
                if (img) {
                    img.src = '{{ url('captcha/flat') }}?' + Math.random();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const googleLink = document.getElementById('google-signup-link');
                const roleInputs = document.querySelectorAll('input[name="role"]');
                
                function updateGoogleLink() {
                    const selectedRole = document.querySelector('input[name="role"]:checked').value;
                    const baseUrl = "{{ route('auth.google') }}";
                    googleLink.href = `${baseUrl}?role=${selectedRole}`;
                }
                
                roleInputs.forEach(input => {
                    input.addEventListener('change', updateGoogleLink);
                });
                
                // Initialize URL
                updateGoogleLink();
            });
        </script>
@endsection
