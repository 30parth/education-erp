<?php

namespace App\Livewire\Forms;

use App\Models\Semester;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SemesterForm extends Form
{
    public ?Semester $semester = null;

    #[Validate('required')]
    public $semesterName;

    #[Validate('required')]
    public $semesterCode;


    public function save()
    {
        if ($this->semester) {
            $this->semester->update([
                'semester_name' => $this->semesterName,
                'semester_code' => $this->semesterCode,
            ]);
        } else {
            Semester::create([
                'semester_name' => $this->semesterName,
                'semester_code' => $this->semesterCode,
            ]);
        }

        $this->reset();
    }
}
