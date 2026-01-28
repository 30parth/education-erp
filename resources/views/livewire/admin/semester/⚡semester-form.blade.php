<?php

use App\Livewire\Forms\SemesterForm;

use App\Models\Semester;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

new class extends Component {
    public SemesterForm $form;

    public string $modalId;

    public function mount(string $modalId, ?Semester $semester = null)
    {
        $this->modalId = $modalId;
        if ($semester) {
            Log::debug($semester);
            $this->form->setSemester($semester);
        } else {
            $this->form->semester = null;
            $this->form->reset();
        }
    }

    public function save()
    {
        $this->form->validate();

        Log::debug($this->form);
        $this->form->save();

        $this->dispatch('closeModal', modalId: $this->modalId);
    }
};
?>

<div>
    <form id="semester-form" wire:submit.prevent="save">
        <x-ui.form.input-with-label label="Semester Name" id="semester_name" name="form.semester_name" />
        <x-ui.form.input-with-label label="Semester Code" id="semester_code" name="form.semester_code" />
    </form>
</div>
