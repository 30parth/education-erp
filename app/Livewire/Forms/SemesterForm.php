<?php

namespace App\Livewire\Forms;

use App\Models\Semester;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SemesterForm extends Form
{
    public ?Semester $semester = null;

    public $semester_name;

    public $semester_code;

    protected function rules()
    {
        return [
            'semester_name' => [
                'required',
                Rule::unique('semesters')->ignore($this->semester),
            ],
            'semester_code' => [
                'required',
                Rule::unique('semesters')->ignore($this->semester),
            ]
        ];
    }
    public function save()
    {
        if ($this->semester) {
            $this->semester->update([
                'semester_name' => $this->semester_name,
                'semester_code' => $this->semester_code,
            ]);
        } else {
            Semester::create([
                'semester_name' => $this->semester_name,
                'semester_code' => $this->semester_code,
            ]);
        }

        $this->reset();
    }

    public function setSemester(Semester $semester)
    {
        $this->semester = $semester;
        $this->semester_name = $semester->semester_name;
        $this->semester_code = $semester->semester_code;
    }
}
