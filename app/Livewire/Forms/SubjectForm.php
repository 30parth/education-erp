<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Form;
use App\Models\Subject;

class SubjectForm extends Form
{
    public ?Subject $subject = null;

    public $subject_name;
    public $subject_code;
    public $semester_id;
    public $status;

    public function rules()
    {
        return [
            'subject_name' => [
                'required',
                Rule::unique('subjects')->ignore($this->subject)
            ],
            'subject_code' => [
                'required',
                Rule::unique('subjects')->ignore($this->subject)
            ],
            'semester_id' => [
                'required',
                Rule::exists('semesters', 'id')
            ],
        ];
    }

    public function setSubject(?Subject $subject)
    {
        $this->subject = $subject;
        $this->subject_name = $subject->subject_name;
        $this->subject_code = $subject->subject_code;
        $this->semester_id = $subject->semester_id;
        $this->status = $subject->status;
    }

    public function save()
    {
        $this->validate();

        if ($this->subject) {
            $this->subject->update([
                'subject_name' => $this->subject_name,
                'subject_code' => $this->subject_code,
                'semester_id' => $this->semester_id,
                // 'status' => $this->status,
            ]);
        } else {
            Subject::create([
                'subject_name' => $this->subject_name,
                'subject_code' => $this->subject_code,
                'semester_id' => $this->semester_id,
                // 'status' => $this->status,
            ]);
        }

        $this->reset();
    }
}
