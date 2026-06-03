<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen">
        <header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-medium">{{ config('app.name', 'Laravel') }}</h1>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="px-4 py-1.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] border border-black dark:border-[#eeeeec] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white transition-colors"
                        >
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-8">
            <div class="mb-8">
                <h2 class="text-2xl font-medium">Dashboard</h2>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">Welcome back, {{ auth()->user()->name }}!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white dark:bg-[#161615] rounded-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <h3 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">My Courses</h3>
                    <p class="text-2xl font-medium mt-2">0</p>
                </div>

                <div class="p-6 bg-white dark:bg-[#161615] rounded-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <h3 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Completed</h3>
                    <p class="text-2xl font-medium mt-2">0</p>
                </div>

                <div class="p-6 bg-white dark:bg-[#161615] rounded-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <h3 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">In Progress</h3>
                    <p class="text-2xl font-medium mt-2">0</p>
                </div>
            </div>

            <div class="mt-8 p-6 bg-white dark:bg-[#161615] rounded-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                <h3 class="text-lg font-medium mb-4">Recent Activity</h3>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">No recent activity yet. Start by enrolling in a course!</p>
            </div>
        </main>
    </body>
</html>