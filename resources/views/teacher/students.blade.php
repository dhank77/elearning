@extends('layouts.teacher')

@section('title', config('app.name', 'EduMentor') . ' - Students List')

@section('content')
    <div class="mx-auto max-w-[1200px] px-margin-mobile pb-40 md:px-10">
            <section class="flex flex-col gap-6 pt-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-[40px] font-bold leading-[48px] text-on-surface">Students</h2>
                    <p class="mt-1 text-body-lg text-on-surface-variant">View and manage your student enrollments.</p>
                </div>
            </section>

            <section class="mt-10 overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                @if($students->isEmpty())
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-[64px] text-on-surface-variant opacity-50">group</span>
                        <p class="mt-4 text-[30px] font-bold text-on-surface">No Students Enrolled</p>
                        <p class="mt-2 text-body-md text-on-surface-variant">When students purchase or enroll in your courses, they will appear here.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-outline-variant bg-surface-container-low/55">
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Student</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Email</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Phone</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Enrolled Courses</th>
                                    <th class="px-6 py-4 font-bold text-label-md text-on-surface-variant">Joined Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/30">
                                @foreach($students as $student)
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-secondary-container font-bold text-secondary">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="font-semibold text-on-surface">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            {{ $student->phone ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($student->courseOrders as $order)
                                                    @if($order->course)
                                                        <span class="inline-flex items-center rounded-md bg-primary-container px-2.5 py-1 text-xs font-medium text-on-primary-container">
                                                            {{ $order->course->title }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-body-md text-on-surface-variant">
                                            @php
                                                $firstOrder = $student->courseOrders->first();
                                                $joinedDate = $firstOrder ? $firstOrder->paid_at?->format('d M Y') ?? $firstOrder->created_at->format('d M Y') : $student->created_at->format('d M Y');
                                            @endphp
                                            {{ $joinedDate }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection
