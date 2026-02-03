<?php

use Livewire\Component;
use App\Models\Student;
use App\Models\TimeTable;
use App\Models\Attendance;

new class extends Component {
    public $date;
    public $lecture_code;
    public $students = [];

    public $options = [['value' => 'present', 'label' => 'Present'], ['value' => 'absent', 'label' => 'Absent']];

    public function searchStudent()
    {
        $this->students = [];
        $this->validate([
            'date' => 'required',
            'lecture_code' => 'required',
        ]);

        $attendance = Attendance::where('date', $this->date)->where('lecture_code', $this->lecture_code)->get();
        if (count($attendance) > 0) {
            $this->students = $attendance->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'student_id' => $attendance->student_id,
                    'name' => $attendance->student->name,
                    'roll_number' => $attendance->student->roll_number,
                    'attendance' => $attendance->status,
                ];
            });
        } else {
            $semester = TimeTable::where('lecture_code', $this->lecture_code)->first()->semester_id;
            $division = TimeTable::where('lecture_code', $this->lecture_code)->first()->division_id;

            $students = Student::where('semester_id', $semester)->where('division_id', $division)->get();

            $this->students = $students->map(function ($student) {
                return [
                    'id' => null,
                    'student_id' => $student->id,
                    'name' => $student->name,
                    'roll_number' => $student->roll_number,
                    'attendance' => null,
                ];
            });
        }
    }

    public function saveAttendance()
    {
        $this->validate([
            'date' => 'required',
            'lecture_code' => 'required',
            'students' => 'required',
        ]);

        foreach ($this->students as $student) {
            if ($student['id']) {
                Attendance::where('id', $student['id'])->update([
                    'status' => $student['attendance'],
                ]);
            } else {
                Attendance::create([
                    'student_id' => $student['student_id'],
                    'date' => $this->date,
                    'lecture_code' => $this->lecture_code,
                    'status' => $student['attendance'],
                ]);
            }
        }
        $this->students = [];
    }
    public function presentAll()
    {
        $this->students = $this->students->map(function ($student) {
            return [
                'student_id' => $student['student_id'],
                'name' => $student['name'],
                'roll_number' => $student['roll_number'],
                'attendance' => 'present',
            ];
        });
    }

    public function updatedDate()
    {
        $this->students = [];
    }
    public function updatedLectureCode()
    {
        $this->students = [];
    }
};
?>

<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col justify-between items-center gap-3 md:flex-row">
            <div class="w-full md:w-1/3">
                <x-ui.form.input-with-label type="date" name="date" label="Date" is-live />
            </div>
            <div class="w-full md:w-1/3">
                <x-dropdown.lecture-dropdown name="lecture_code" :date="$date" />
            </div>
            <div class="w-full md:w-1/3">
                <div class="flex flex-col md:flex-row">
                    <x-ui.button wire:click="searchStudent">
                        Search
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>

    @if ($students)
        <div class="w-full mt-4">
            <div class="flex justify-between">
                <x-ui.button wire:confirm="Are you sure you want to mark all students as present?"
                    wire:click="presentAll">
                    Present All
                </x-ui.button>
                <x-ui.button wire:click="saveAttendance">
                    Save Attendance
                </x-ui.button>
            </div>
        </div>

        <div class=" mt-4">
            <x-ui.table.table>
                <x-ui.table.head>
                    <tr>
                        <x-ui.table.th>Roll No</x-ui.table.th>
                        <x-ui.table.th>Name</x-ui.table.th>
                        <x-ui.table.th>Attendance</x-ui.table.th>
                    </tr>
                </x-ui.table.head>
                <x-ui.table.body>
                    @foreach ($students as $index => $student)
                        <x-ui.table.row>
                            <x-ui.table.td>{{ $student['roll_number'] }}</x-ui.table.td>
                            <x-ui.table.td>{{ $student['name'] }}</x-ui.table.td>
                            <x-ui.table.td>
                                <x-ui.form.radio-button name="students.{{ $index }}.attendance" :options="$options"
                                    orientation="horizontal" />
                            </x-ui.table.td>
                        </x-ui.table.row>
                    @endforeach
                </x-ui.table.body>
            </x-ui.table.table>
        </div>
    @endif
</div>
