<?php

use Livewire\Component;
use App\Models\Timetable;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $timetable;
    public function mount()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();

        $this->timetable = Timetable::with(['subject', 'teacher'])
            ->where('semester_id', $student->semester_id)
            ->where('division_id', $student->division_id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day')
            ->toArray();
    }
};
?>

<div class="p-4">

    <div class="mt-6 pb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                <div class="flex flex-col gap-3">
                    <div class="font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-2">
                        {{ ucfirst($day) }}
                    </div>

                    @if (isset($timetable[$day]))
                        @foreach ($timetable[$day] as $item)
                            <div
                                class="bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm hover:shadow-md transition-shadow">
                                {{-- Subject --}}
                                <div class="flex items-start gap-2 mb-2">
                                    {{-- Icon (optional, per user request can be omitted but keeping structure simple) --}}
                                    <div class="text-green-600 font-medium text-sm">
                                        Subject: {{ $item['subject']['subject_name'] }}
                                        <span class="text-green-500">({{ $item['subject']['subject_code'] }})</span>
                                    </div>
                                </div>

                                {{-- Time --}}
                                <div class="flex items-center gap-2 mb-2 text-gray-600 text-xs">
                                    <span>
                                        {{ \Carbon\Carbon::parse($item['start_time'])->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($item['end_time'])->format('h:i A') }}
                                    </span>
                                </div>

                                {{-- Teacher --}}
                                <div class="flex items-center gap-2 mb-2 text-green-600 text-sm">
                                    <span>
                                        {{ $item['teacher']['name'] }}
                                    </span>
                                </div>

                                {{-- Room (Placeholder if needed, derived from image) --}}
                                {{-- <div class="flex items-center gap-2 text-gray-500 text-xs">
                                        <span>Room No.: 111</span>
                                    </div> --}}
                            </div>
                        @endforeach
                    @else
                        {{-- Optional: Empty state for the day --}}
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>
