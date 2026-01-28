<?php

use Livewire\Component;
use App\Models\Subject;
use App\Livewire\Forms\SubjectForm;

new class extends Component {
    public SubjectForm $form;

    public $modalId;

    public function mount(string $modalId, ?Subject $subject)
    {
        $this->modalId = $modalId;
        if ($subject) {
            $this->form->setSubject($subject);
        }
    }

    public function save()
    {
        $this->form->save();
        $this->dispatch('closeModal', modalId: $this->modalId);
        $this->reset();
    }
};
?>

<div>
    <form id="subject-form" wire:submit.prevent="save">
        <x-ui.form.input-with-label label="Subject Name" id="subject_name" name="form.subject_name" />
        <x-ui.form.input-with-label label="Subject Code" id="subject_code" name="form.subject_code" />
        <x-dropdown.semester-dropdown id="semester_id" name="form.semester_id" />
        <x-common.status-radio-button name="form.status" />
    </form>
</div>
