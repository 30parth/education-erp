<?php

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Semester;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use WithPagination;

    use HasRefreshListener;

    public $search = '';

    public $id = 0;

    #[Computed]
    public function semesterList()
    {
        return Semester::where('semester_name', 'like', '%' . $this->search . '%')
            ->where('semester_code', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }
    public function delete($id)
    {
        $semester = Semester::find($id);
        $semester->delete();

        $this->dispatch('refresh');
    }
};
?>


@php
    $isEdit = $id > 0 ? true : false;
    $modalTitle = $isEdit ? 'Edit Semester' : 'Add Semester';
    $footerButton = $isEdit ? 'Update' : 'Save';
@endphp
<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between  space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <x-common.search-filter />
            <div
                class="flex flex-col  justify-end w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <x-ui.button data-modal-target="semester-form-modal" data-modal-show="semester-form-modal"
                    wire:click="$set('id', 0)">
                    Add Semester
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <x-ui.table>
            <x-ui.table.head>
                <tr>
                    <x-ui.table.th>
                        Sr No
                    </x-ui.table.th>
                    <x-ui.table.th>
                        Semester Name
                    </x-ui.table.th>
                    <x-ui.table.th>
                        Semester Code
                    </x-ui.table.th>
                    <x-ui.table.th class="text-between">
                        Action
                    </x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($this->semesterList as $index => $semester)
                    <x-ui.table.row wire:key="{{ $semester->id }}">
                        <x-ui.table.td>
                            {{ $index + 1 }}
                        </x-ui.table.td>
                        <x-ui.table.td>
                            {{ $semester->semester_name }}
                        </x-ui.table.td>
                        <x-ui.table.td>
                            {{ $semester->semester_code }}
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <x-common.action-button id="{{ $semester->id }}" modalId="semester-form-modal" />
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>

        {{ $this->semesterList->links() }}

    </div>

    <x-ui.modal title="{{ $modalTitle }}" id="semester-form-modal" footerButton="{{ $footerButton }}" size="sm"
        formId="semester-form" wire:ignore.self>
        @livewire(
            'admin.semester.semester-form',
            [
                'modalId' => 'semester-form-modal',
                'semester' => $id ?: null,
            ],
            key('semester-form-' . $id)
        )
    </x-ui.modal>
</div>
