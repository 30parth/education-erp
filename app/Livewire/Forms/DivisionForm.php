<?php

namespace App\Livewire\Forms;

use App\Models\Division;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DivisionForm extends Form
{
    public ?Division $division = null;

    #[Validate('required')]
    public $division_name;

    #[Validate('required')]
    public $semester_id;

    public function rules()
    {
        return [
            'division_name' => [
                'required',
                Rule::unique('divisions', 'division_name')->ignore($this->division?->id),
            ],
            'semester_id' => [
                'required',
                Rule::exists('semesters', 'id'),
            ],
        ];
    }

    public function setDivision(Division $division)
    {
        $this->division = $division;
        $this->division_name = $division->division_name;
        $this->semester_id = $division->semester_id;
    }

    public function save()
    {
        if ($this->division) {
            $this->division->update($this->all());
        } else {
            Division::create($this->all());
        }
    }
}
