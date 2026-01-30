<?php

use Livewire\Component;
use App\Livewire\Forms\DivisionForm;
use App\Models\Division;

new class extends Component {
    public DivisionForm $form;

    public $modalId;

    public function mount(string $modalId, ?Division $division = null)
    {
        $this->modalId = $modalId;
        if ($division) {
            $this->form->setDivision($division);
        }
    }

    public function save()
    {
        $this->form->validate();
        $this->form->save();
        $this->dispatch('closeModal', modalId: $this->modalId);

        $this->reset();
    }
};
?>

<div>
    <form wire:submit.prevent="save" id="division-form">
        <x-ui.form.input-with-label label="Division Name" name="form.division_name" />
        <x-dropdown.semester-dropdown name="form.semester_id" />
    </form>
</div>
