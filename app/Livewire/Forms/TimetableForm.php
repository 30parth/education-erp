<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TimetableForm extends Form
{
    #[Validate('required')]
    public $semester_id;
    #[Validate('required')]
    public $division_id;
    #[Validate('required')]
    public $week_day;

    public $timetables = [];

    public function rules()
    {
        return [
            'semester_id' => 'required',
            'division_id' => 'required',
            'week_day' => 'required',
            'timetables.*.subject_id' => 'required',
            'timetables.*.teacher_id' => 'required',
            'timetables.*.start_time' => 'required',
            'timetables.*.end_time' => 'required',
        ];
    }

    public function setForm($timetable)
    {
        $this->semester_id = $timetable->semester_id;
        $this->division_id = $timetable->division_id;
        $this->week_day = $timetable->week_day;
    }

    public function addTimetable()
    {
        $this->timetables[] = [
            'id' => '',
            'subject_id' => '',
            'teacher_id' => '',
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function removeTimetable($index)
    {
        unset($this->timetables[$index]);
    }
}
