<?php

use Livewire\Component;
use App\Livewire\Forms\TimetableForm;
use App\Models\TimeTable;
use App\Models\Semester;
use App\Models\Division;
use App\Models\Subject;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use HasRefreshListener;

    public TimetableForm $form;

    public function fetchTimeTabel()
    {
        $this->form->timetables = [];

        $timeTable = TimeTable::where('semester_id', $this->form->semester_id)->where('division_id', $this->form->division_id)->where('day', $this->form->week_day)->get();

        foreach ($timeTable as $timetable) {
            $this->form->timetables[] = [
                'id' => $timetable->id,
                'subject_id' => $timetable->subject_id,
                'lecture_code' => $timetable->lecture_code,
                'teacher_id' => $timetable->teacher_id,
                'start_time' => $timetable->start_time,
                'end_time' => $timetable->end_time,
            ];
        }

        if (count($this->form->timetables) == 0) {
            $this->addTimetable();
        }
    }

    public function updatedFormSemesterId()
    {
        $this->form->timetables = [];
    }

    public function updatedFormDivisionId()
    {
        $this->form->timetables = [];
    }

    public function updatedFormWeekDay()
    {
        $this->form->timetables = [];
    }

    public function saveTimetable()
    {
        foreach ($this->form->timetables as $index => $timetable) {
            $semester = Semester::find($this->form->semester_id);
            $division = Division::find($this->form->division_id);
            $subject = Subject::find($timetable['subject_id']);

            $timetable['semester_id'] = $this->form->semester_id;
            $timetable['division_id'] = $this->form->division_id;
            $timetable['day'] = $this->form->week_day;
            $timetable['lecture_code'] = $index + 1 . '_' . $this->form->week_day . '_' . $semester->semester_code . '_' . $division->division_name . '_' . $subject->subject_name;

            if ($timetable['id']) {
                TimeTable::where('id', $timetable['id'])->update($timetable);
            } else {
                TimeTable::create($timetable);
            }
        }
        $this->form->reset();
        $this->dispatch('refresh');
    }

    public function addTimetable()
    {
        $this->form->addTimetable();
    }

    public function removeTimetable($index)
    {
        if ($this->form->timetables[$index]['id']) {
            TimeTable::where('id', $this->form->timetables[$index]['id'])->delete();
        }
        $this->form->removeTimetable($index);
    }
};
?>

<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between space-y-3 space-x-3 md:flex-row">
            <div class="w-full md:w-1/4">
                <x-dropdown.semester-dropdown name="form.semester_id" is-live />
            </div>
            <div class="w-full md:w-1/4">
                <x-dropdown.division-dropdown :semesterId="$form->semester_id" name="form.division_id" is-live />
            </div>
            <div class="w-full md:w-1/4">
                <x-dropdown.week-day-dropdown name="form.week_day" is-live />
            </div>
            <div class="w-full md:w-1/4">
                <div class="flex flex-col md:flex-row">
                    <x-ui.button wire:click="fetchTimeTabel">Fetch Time Table</x-ui.button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex justify-end mb-3">
            <x-ui.button wire:click="addTimetable">Add Timetable</x-ui.button>
        </div>
        <x-ui.table.table>
            <x-ui.table.head>
                <tr>
                    <x-ui.table.th>Subject</x-ui.table.th>
                    <x-ui.table.th>Teacher</x-ui.table.th>
                    <x-ui.table.th>Start Time</x-ui.table.th>
                    <x-ui.table.th>End Time</x-ui.table.th>
                    <x-ui.table.th>Action</x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($form->timetables as $index => $timetable)
                    <x-ui.table.row wire:key="{{ $timetable['id'] }}">
                        <x-ui.table.td>
                            <x-dropdown.subject-dropdown :semesterId="$form->semester_id" no-label
                                name="form.timetables.{{ $index }}.subject_id" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <x-dropdown.teacher-dropdown no-label
                                name="form.timetables.{{ $index }}.teacher_id" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.form.input-with-label no-label name="form.timetables.{{ $index }}.start_time"
                                type="time" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.form.input-with-label no-label name="form.timetables.{{ $index }}.end_time"
                                type="time" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <div class="cursor-pointer" wire:click="removeTimetable({{ $index }})">
                                <x-ui.icon.trash />
                            </div>
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table.table>
        <x-ui.button class="mt-4" wire:click="saveTimetable">Save Timetable</x-ui.button>
    </div>
</div>
