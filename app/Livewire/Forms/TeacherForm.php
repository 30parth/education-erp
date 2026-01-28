<?php

namespace App\Livewire\Forms;

use App\Models\Teacher;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TeacherForm extends Form
{
    public ?Teacher $teacher = null;

    #[Validate('required')]
    public $staff_id = '';

    #[Validate('required')]
    public $role = '';

    #[Validate('nullable')]
    public $date_of_joining = '';

    #[Validate('nullable')]
    public $pan_number = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('nullable')]
    public $father_name = '';

    #[Validate('required')]
    public $gender = '';

    #[Validate('nullable')]
    public $date_of_birth = '';

    #[Validate('nullable')]
    public $qualification = '';

    #[Validate('nullable')]
    public $work_experience = '';

    #[Validate('nullable')]
    public $note = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $mobile_number = '';

    #[Validate('nullable')]
    public $address = '';

    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
        $this->staff_id = $teacher->staff_id;
        $this->role = $teacher->role;
        $this->date_of_joining = $teacher->date_of_joining;
        $this->pan_number = $teacher->pan_number;
        $this->name = $teacher->name;
        $this->father_name = $teacher->father_name;
        $this->gender = $teacher->gender;
        $this->date_of_birth = $teacher->date_of_birth;
        $this->qualification = $teacher->qualification;
        $this->work_experience = $teacher->work_experience;
        $this->note = $teacher->note;
        $this->email = $teacher->email;
        $this->mobile_number = $teacher->mobile_number;
        $this->address = $teacher->address;
    }

    public function save()
    {
        $this->validate();

        if ($this->teacher) {
            $this->teacher->update($this->all());
        } else {
            Teacher::create($this->all());
        }

        $this->reset();
    }
}
