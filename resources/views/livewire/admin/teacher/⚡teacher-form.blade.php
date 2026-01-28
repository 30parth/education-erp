<?php

use App\Livewire\Forms\TeacherForm;
use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

new class extends Component {
    public TeacherForm $form;
    public string $modalId;

    public function mount(string $modalId, ?Teacher $teacher = null)
    {
        $this->modalId = $modalId;
        if ($teacher) {
            $this->form->setTeacher($teacher);
        } else {
            $this->form->teacher = null;
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
    <form id="teacher-form" wire:submit.prevent="save">

        {{-- Row 1 --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <x-ui.form.input-with-label id="staff_id" name="form.staff_id" label="Staff ID :" required />
            <x-dropdown.role-dropdown id="role" name="form.role" required />
            <x-ui.form.input-with-label id="date_of_joining" name="form.date_of_joining" label="Date Of Joining :"
                type="date" required />
            <x-ui.form.input-with-label id="pan_number" name="form.pan_number" label="PAN Number :" />
        </div>

        {{-- Row 2 --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <x-ui.form.input-with-label id="name" name="form.name" label="Name :" required />
            <x-ui.form.input-with-label id="father_name" name="form.father_name" label="Father Name :" />
            <x-dropdown.gender-dropdown id="gender" name="form.gender" required />
            <x-ui.form.input-with-label id="date_of_birth" name="form.date_of_birth" label="Date Of Birth :"
                type="date" required />
        </div>

        {{-- Row 3 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <x-ui.form.input-with-label id="qualification" name="form.qualification" label="Qualification :" />
            <x-ui.form.input-with-label id="work_experience" name="form.work_experience" label="Work Experience :" />
            <x-ui.form.input-with-label id="note" name="form.note" label="Note :" />
        </div>

        {{-- Row 4 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <x-ui.form.input-with-label id="email" name="form.email" label="Email (Login Username) :" type="email"
                required />
            <x-ui.form.input-with-label id="mobile_number" name="form.mobile_number" label="Phone :" required />
            <x-ui.form.input-with-label id="address" name="form.address" label="Address :" />
        </div>
    </form>
</div>
