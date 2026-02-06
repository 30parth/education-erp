<?php

use Livewire\Component;
use App\Models\TimeTable;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $weekDays = [];
    public $timeSlots = [];
    public $timetableData = [];

    public function mount()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return;
        }

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Generate dates for the current week
        $currentDate = $startOfWeek->copy();
        while ($currentDate->lte($endOfWeek)) {
            $this->weekDays[] = [
                'date' => $currentDate->format('Y-m-d'),
                'day_name' => $currentDate->format('l'),
                'display_date' => $currentDate->format('d M'),
            ];
            $currentDate->addDay();
        }

        // Fetch Timetable
        $timetables = TimeTable::with(['subject', 'teacher'])
            ->where('semester_id', $student->semester_id)
            ->where('division_id', $student->division_id)
            ->get();

        // Fetch Attendance
        $attendances = Attendance::where('student_id', $student->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get()
            ->keyBy(function ($item) {
                return $item->date . '_' . $item->lecture_code;
            });

        // Structure Data
        foreach ($this->weekDays as $day) {
            $dayName = strtolower($day['day_name']);
            $date = $day['date'];

            // Filter timetable for this day
            $dayTimetable = $timetables->where('day', $dayName)->sortBy('start_time');

            foreach ($dayTimetable as $slot) {
                // Ensure unique time slots list
                $timeKey = $slot->start_time . ' - ' . $slot->end_time;
                if (!in_array($timeKey, $this->timeSlots)) {
                    $this->timeSlots[] = $timeKey;
                }

                $attendanceKey = $date . '_' . $slot->lecture_code;
                $status = 'Scheduled';
                $color = 'bg-gray-100 border-gray-200'; // Default

                if (isset($attendances[$attendanceKey])) {
                    $attendanceRecord = $attendances[$attendanceKey];
                    if ($attendanceRecord->status == 'present') {
                        $status = 'Present';
                        $color = 'bg-success-soft border-success-subtle text-fg-success-strong';
                    } elseif ($attendanceRecord->status == 'absent') {
                        $status = 'Absent';
                        $color = 'bg-danger-soft border-danger-subtle text-fg-danger-strong';
                    }
                }

                $this->timetableData[$date][$timeKey][] = [
                    'subject' => $slot->subject->subject_name ?? 'N/A',
                    'teacher' => $slot->teacher->name ?? 'N/A',
                    'status' => $status,
                    'color' => $color,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                ];
            }
        }

        // Sort time slots
        sort($this->timeSlots);
    }
};
?>

<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Student Dashboard</h1>
            <p class="text-gray-600">Weekly Attendance & Timetable</p>
        </div>
        <div class="text-right">
            <span class="px-4 py-2 bg-white rounded-lg shadow-sm border text-sm font-medium">
                {{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M, Y') }}
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 border-b">
                    <tr>
                        <th class="px-6 py-4 font-semibold whitespace-nowrap w-32">Time / Date</th>
                        @foreach ($weekDays as $day)
                            <th class="px-6 py-4 font-semibold text-center whitespace-nowrap min-w-[200px]">
                                <div class="text-gray-900">{{ $day['day_name'] }}</div>
                                <div class="text-xs text-gray-500 font-normal">{{ $day['display_date'] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($timeSlots as $timeSlot)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-50/30">
                                {{ $timeSlot }}
                            </td>
                            @foreach ($weekDays as $day)
                                <td class="px-4 py-3 align-top">
                                    @if (isset($timetableData[$day['date']][$timeSlot]))
                                        @foreach ($timetableData[$day['date']][$timeSlot] as $class)
                                            <div
                                                class="p-3 rounded-lg border {{ $class['color'] }} mb-2 last:mb-0 transition-all hover:shadow-md">
                                                <div class="font-bold text-gray-900 mb-1 line-clamp-1"
                                                    title="{{ $class['subject'] }}">
                                                    {{ $class['subject'] }}
                                                </div>
                                                <div class="flex items-center gap-2 text-xs mb-2 opacity-80">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    <span class="truncate"
                                                        title="{{ $class['teacher'] }}">{{ $class['teacher'] }}</span>
                                                </div>
                                                <div
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold w-full justify-center">
                                                    {{ $class['status'] }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div
                                            class="h-full min-h-[80px] rounded-lg border border-dashed border-gray-200 bg-gray-50/50 flex items-center justify-center text-gray-400 text-xs">
                                            No Class
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($weekDays) + 1 }}" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="font-medium">No timetable available for this week</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
