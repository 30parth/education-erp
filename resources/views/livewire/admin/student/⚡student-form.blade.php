<?php

use App\Livewire\Forms\StudentForm;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

new class extends Component {
    public StudentForm $form;
    public string $modalId;

    public function mount(string $modalId, ?Student $student = null)
    {
        $this->modalId = $modalId;
        if ($student) {
            $this->form->setStudent($student);
        } else {
            $this->form->student = null;
            $this->form->reset();
        }
    }

    public function save()
    {
        $this->form->validate();
        $this->form->save();

        $this->dispatch('closeModal', modalId: $this->modalId);
        $this->dispatch('refresh'); // Dispatch refresh to update the list
    }
};
?>

<div>
    <form id="student-form" wire:submit.prevent="save">
        <div class="mb-4">
            <x-ui.form.input-with-label id="medical_history" name="form.medical_history" label="Medical History :"
                placeholder="Any known medical history..." />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <x-ui.form.input-with-label id="admission_no" name="form.admission_no" label="Admission No :" />
            <x-ui.form.input-with-label id="roll_number" name="form.roll_number" label="Roll Number :" />
            <x-dropdown.semester-dropdown id="semester_id" name="form.semester_id" />
            <x-dropdown.section-dropdown id="section" name="form.section" />
            <x-ui.form.input-with-label id="admission_date" name="form.admission_date" label="Admission Date :"
                type="date" />
            <x-dropdown.category-dropdown id="category" name="form.category" />
            <x-ui.form.input-with-label id="name" name="form.name" label="Name :" />
            <x-dropdown.gender-dropdown id="gender" name="form.gender" />
            <x-ui.form.input-with-label id="date_of_birth" name="form.date_of_birth" label="Date Of Birth :"
                type="date" />
            <x-dropdown.blood-group-dropdown id="blood_group" name="form.blood_group" />
            <x-ui.form.input-with-label id="mobile_number" name="form.mobile_number" label="Mobile Number :" />
            <x-ui.form.input-with-label id="email" name="form.email" label="Email :" type="email" />
        </div>
    </form>
</div>
