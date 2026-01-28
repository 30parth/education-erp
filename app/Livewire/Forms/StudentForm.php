<?php

namespace App\Livewire\Forms;

use App\Models\Student;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StudentForm extends Form
{
    public ?Student $student = null;

    #[Validate('required')]
    public $admission_no = '';

    #[Validate('required')]
    public $roll_number = '';

    #[Validate('required')]
    public $semester_id = '';

    #[Validate('required')]
    public $section = '';

    #[Validate('required')]
    public $admission_date = '';

    #[Validate('required')]
    public $category = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $gender = '';

    #[Validate('required')]
    public $date_of_birth = '';

    #[Validate('nullable')]
    public $blood_group = '';

    #[Validate('required')]
    public $mobile_number = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('nullable')]
    public $medical_history = '';

    public function setStudent(Student $student)
    {
        $this->student = $student;
        $this->admission_no = $student->admission_no;
        $this->roll_number = $student->roll_number;
        $this->semester_id = $student->semester_id;
        $this->section = $student->section;
        $this->admission_date = $student->admission_date;
        $this->category = $student->category;
        $this->name = $student->name;
        $this->gender = $student->gender;
        $this->date_of_birth = $student->date_of_birth;
        $this->blood_group = $student->blood_group;
        $this->mobile_number = $student->mobile_number;
        $this->email = $student->email;
        $this->medical_history = $student->medical_history;
    }

    public function save()
    {
        $this->validate();

        if ($this->student) {
            $this->student->update($this->all());
        } else {
            Student::create($this->all());
        }

        $this->reset();
    }
}
