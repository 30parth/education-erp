<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subject;
use Livewire\Attributes\Computed;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use WithPagination;

    use HasRefreshListener;

    public $search = '';

    public $id = 0;

    #[Computed]
    public function subjectList()
    {
        $query = Subject::query();

        $query->where('subject_name', 'like', '%' . $this->search . '%')->orWhere('subject_code', 'like', '%' . $this->search . '%');

        $query->orWhereHas('semester', function ($query) {
            $query->where('semester_name', 'like', '%' . $this->search . '%');
        });

        return $query->paginate(10);
    }
    public function delete($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        $this->dispatch('refresh');
    }
};
?>
@php
    $isEdit = $id > 0;
    $title = $isEdit ? 'Edit Subject' : 'Create Subject';
    $footerButton = $isEdit ? 'Update' : 'Save';
@endphp
<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between  space-y-3 md:flex-row">
            <x-common.search-filter />
            <div class="flex flex-col justify-end w-full md:flex-row">
                <x-ui.button data-modal-target="subject-form-modal" data-modal-show="subject-form-modal">
                    Add Subject
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <x-ui.table.table>
            <x-ui.table.head>
                <tr>
                    <x-ui.table.th>Sr No</x-ui.table.th>
                    <x-ui.table.th>Semester</x-ui.table.th>
                    <x-ui.table.th>Name</x-ui.table.th>
                    <x-ui.table.th>Code</x-ui.table.th>
                    <x-ui.table.th>Actions</x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($this->subjectList as $index => $subject)
                    <x-ui.table.row>
                        <x-ui.table.td>{{ $index + 1 }}</x-ui.table.td>
                        <x-ui.table.td>{{ $subject->semester->semester_name }}</x-ui.table.td>
                        <x-ui.table.td>{{ $subject->subject_name }}</x-ui.table.td>
                        <x-ui.table.td>{{ $subject->subject_code }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-common.action-button id="{{ $subject->id }}" modalId="subject-form-modal" />
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table.table>
        {{ $this->subjectList->links() }}
    </div>

    <x-ui.modal id="subject-form-modal" formId="subject-form" footerButton="{{ $footerButton }}"
        title="{{ $title }}" size="md" wire:ignore.self>
        @livewire(
            'admin.subject.subject-form',
            [
                'modalId' => 'subject-form-modal',
                'subject' => $id ?: null,
            ],
            key('subject-form' . $id)
        )
    </x-ui.modal>
</div>
