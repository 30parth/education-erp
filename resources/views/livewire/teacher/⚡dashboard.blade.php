<?php

use Livewire\Component;
use App\Models\Student;
use App\Models\TimeTable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

new class extends Component {
    public function with()
    {
        $day = strtolower(Carbon::now()->format('l'));
        $teacher = Auth::user()->teacher;

        $todaysSchedule = [];
        if ($teacher) {
            $todaysSchedule = TimeTable::where('teacher_id', $teacher->id)
                ->where('day', $day)
                ->with(['semester', 'division', 'subject'])
                ->orderBy('start_time')
                ->get();
        }

        return [
            'totalStudents' => Student::count(),
            'todaysSchedule' => $todaysSchedule,
        ];
    }

    public function goToStudentList()
    {
        return redirect()->route('teacher.student.list');
    }
};
?>

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Teacher Dashboard</h1>

    <!-- Stats Grid -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <!-- Students Card -->
        <div
            class="w-full md:w-1/2 p-6 bg-white border border-gray-200 rounded-base shadow dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Students</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400 text-4xl">{{ $totalStudents }}</p>
            </div>
            <x-ui.button variant="secondary" class="inline-flex gap-2" wire:click="goToStudentList">
                View All
                <x-ui.icon.arrow-right />
            </x-ui.button>
        </div>

        <!-- Schedule Table -->
        <div class="w-full md:w-1/2 space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Today's Schedule
                ({{ Carbon::now()->format('l, d M Y') }})</h2>
            @if (count($todaysSchedule) > 0)
                @foreach ($todaysSchedule as $schedule)
                    <div
                        class="bg-white border border-gray-200 rounded-base px-3 py-2 shadow-sm hover:shadow-md transition-shadow">
                        {{-- Subject --}}
                        <div class="flex items-start gap-2 mb-2">
                            {{-- Icon (optional, per user request can be omitted but keeping structure simple) --}}
                            <div class="text-green-600 font-medium text-sm">
                                Subject: {{ $schedule['subject']['subject_name'] }}
                                <span class="text-green-500">({{ $schedule['subject']['subject_code'] }})</span>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="flex items-center gap-2 mb-2 text-gray-600 text-xs">
                            <span>
                                {{ \Carbon\Carbon::parse($schedule['start_time'])->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($schedule['end_time'])->format('h:i A') }}
                            </span>
                        </div>

                        {{-- Teacher --}}
                        <div class="flex items-center gap-2 mb-2 text-green-600 text-sm">
                            <span>
                                {{ $schedule['teacher']['name'] }}
                            </span>
                        </div>

                        {{-- Room (Placeholder if needed, derived from image) --}}
                        {{-- <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <span>Room No.: 111</span>
                    </div> --}}
                    </div>
                @endforeach
            @else
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                    role="alert">
                    <span class="font-medium">Info alert!</span> No lectures scheduled for today.
                </div>
            @endif
        </div>
    </div>
</div>
