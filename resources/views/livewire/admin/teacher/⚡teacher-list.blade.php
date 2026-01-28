<?php

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Teacher;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use WithPagination;
    use HasRefreshListener;

    public $search = '';
    public $id = 0;

    #[Computed]
    public function teacherList()
    {
        return Teacher::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('staff_id', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();

        $this->dispatch('refresh');
    }
};
?>

@php
    $isEdit = $id > 0 ? true : false;
    $modalTitle = $isEdit ? 'Edit Teacher' : 'Add Teacher';
    $footerButton = $isEdit ? 'Update' : 'Save';
@endphp

<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between space-y-3 md:flex-row">
            <x-common.search-filter />
            <div class="flex flex-col justify-end w-full md:flex-row">
                <x-ui.button data-modal-target="teacher-form-modal" data-modal-show="teacher-form-modal">
                    Add Teacher
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <x-ui.table>
            <x-ui.table.head>
                <tr>
                    <x-ui.table.th>Sr No</x-ui.table.th>
                    <x-ui.table.th>Staff ID</x-ui.table.th>
                    <x-ui.table.th>Name</x-ui.table.th>
                    <x-ui.table.th>Role</x-ui.table.th>
                    <x-ui.table.th>Contact</x-ui.table.th>
                    <x-ui.table.th class="text-between">Action</x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($this->teacherList as $index => $teacher)
                    <x-ui.table.row wire:key="{{ $teacher->id }}">
                        <x-ui.table.td>{{ $index + 1 }}</x-ui.table.td>
                        <x-ui.table.td>{{ $teacher->staff_id }}</x-ui.table.td>
                        <x-ui.table.td>{{ $teacher->name }}</x-ui.table.td>
                        <x-ui.table.td>{{ $teacher->role }}</x-ui.table.td>
                        <x-ui.table.td>{{ $teacher->mobile_number }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-common.action-button id="{{ $teacher->id }}" modalId="teacher-form-modal" />
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>

        {{ $this->teacherList->links() }}
    </div>

    <x-ui.modal title="{{ $modalTitle }}" id="teacher-form-modal" footerButton="{{ $footerButton }}" size="2xl"
        formId="teacher-form" wire:ignore.self>
        @livewire(
            'admin.teacher.teacher-form',
            [
                'modalId' => 'teacher-form-modal',
                'teacher' => $id ?: null,
            ],
            key('teacher-form-' . $id)
        )
    </x-ui.modal>
</div>
