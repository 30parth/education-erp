<?php

use App\Livewire\Forms\SemesterForm;
use Livewire\Component;

new class extends Component {
    public SemesterForm $form;

    public string $modalId;

    public function mount(string $modalId)
    {
        $this->modalId = $modalId;
    }

    public function save()
    {
        $this->form->validate();

        $this->form->save();

        $this->dispatch('closeModal', modalId: $this->modalId);
    }
};
?>

<div>
    <form id="semester-form" wire:submit.prevent="save">
        <x-ui.input-with-label label="Semester Name" id="semester_name" name="form.semesterName" />
        <x-ui.input-with-label label="Semester Code" id="semester_code" name="form.semesterCode" />
    </form>
</div>
