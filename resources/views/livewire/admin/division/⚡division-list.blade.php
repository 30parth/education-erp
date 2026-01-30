<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Division;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use WithPagination;

    use HasRefreshListener;

    public $search = '';

    public $id = 0;

    #[Computed]
    public function divisionList()
    {
        return Division::where('division_name', 'like', '%' . $this->search . '%')
            ->orWhereHas('semester', function ($query) {
                $query->where('semester_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function delete($id)
    {
        $division = Division::find($id);
        $division->delete();

        $this->dispatch('refresh');
    }
};
?>

@php
    $isEdit = $id > 0 ? true : false;
    $modalTitle = $isEdit ? 'Edit Division' : 'Add Division';
    $footerButton = $isEdit ? 'Update' : 'Save';
@endphp
<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between  space-y-3 md:flex-row">
            <x-common.search-filter />
            <div class="flex flex-col justify-end w-full md:flex-row">
                <x-ui.button data-modal-target="division-form-modal" data-modal-show="division-form-modal">
                    Add Division
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <x-ui.table>
            <tr>
                <x-ui.table.row>
                    <x-ui.table.th>Sr No</x-ui.table.th>
                    <x-ui.table.th>Semester</x-ui.table.th>
                    <x-ui.table.th>Name</x-ui.table.th>
                    <x-ui.table.th>Actions</x-ui.table.th>
                </x-ui.table.row>
            </tr>
            <x-ui.table.body>
                @foreach ($this->divisionList as $index => $division)
                    <x-ui.table.row>
                        <x-ui.table.td>{{ $index + 1 }}</x-ui.table.td>
                        <x-ui.table.td>{{ $division->semester->semester_name }}</x-ui.table.td>
                        <x-ui.table.td>{{ $division->division_name }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-common.action-button id="{{ $division->id }}" modalId="division-form-modal" />
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>
        {{ $this->divisionList->links() }}
    </div>

    <x-ui.modal title="{{ $modalTitle }}" id="division-form-modal" footerButton="{{ $footerButton }}" size="sm"
        formId="division-form" wire:ignore.self>
        @livewire(
            'admin.division.division-form',
            [
                'modalId' => 'division-form-modal',
                'division' => $id ?: null,
            ],
            key('division-form-' . $id)
        )
    </x-ui.modal>
</div>
