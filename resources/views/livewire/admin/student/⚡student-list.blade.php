<?php

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Student;
use App\Livewire\Concerns\HasRefreshListener;

new class extends Component {
    use WithPagination;
    use HasRefreshListener;

    public $search = '';
    public $id = 0;

    #[Computed]
    public function studentList()
    {
        return Student::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('admission_no', 'like', '%' . $this->search . '%')
            ->with(['semester']) // Eager load semester
            ->paginate(10);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();

        $this->dispatch('refresh');
    }
};
?>

@php
    $isEdit = $id > 0 ? true : false;
    $modalTitle = $isEdit ? 'Edit Student' : 'Add Student';
    $footerButton = $isEdit ? 'Update' : 'Save';
@endphp

<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between space-y-3 md:flex-row">
            <x-common.search-filter />
            <div class="flex flex-col justify-end w-full md:flex-row">
                <form action="{{ route('admin.student.import') }}" method="POST" enctype="multipart/form-data" class="inline-block mr-2">
                    @csrf
                    <input type="file" name="file" class="hidden" id="import-file" onchange="this.form.submit()">
                    <x-ui.button type="button" onclick="document.getElementById('import-file').click()" class="bg-blue-600 hover:bg-blue-700">
                        Import Excel
                    </x-ui.button>
                </form>
                <a href="{{ route('admin.student.export') }}" class="mr-2">
                    <x-ui.button type="button" class="bg-green-600 hover:bg-green-700">
                        Export Excel
                    </x-ui.button>
                </a>
                <x-ui.button data-modal-target="student-form-modal" data-modal-show="student-form-modal">
                    Add Student
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <x-ui.table>
            <x-ui.table.head>
                <tr>
                    <x-ui.table.th>Sr No</x-ui.table.th>
                    <x-ui.table.th>Admission No</x-ui.table.th>
                    <x-ui.table.th>Name</x-ui.table.th>
                    <x-ui.table.th>Semester</x-ui.table.th>
                    <x-ui.table.th>Section</x-ui.table.th>
                    <x-ui.table.th class="text-between">Action</x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($this->studentList as $index => $student)
                    <x-ui.table.row wire:key="{{ $student->id }}">
                        <x-ui.table.td>{{ $index + 1 }}</x-ui.table.td>
                        <x-ui.table.td>{{ $student->admission_no }}</x-ui.table.td>
                        <x-ui.table.td>{{ $student->name }}</x-ui.table.td>
                        <x-ui.table.td>{{ $student->semester ? $student->semester->semester_name : 'N/A' }}</x-ui.table.td>
                        <x-ui.table.td>{{ $student->division->division_name }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-common.action-button id="{{ $student->id }}" modalId="student-form-modal" />
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>

        {{ $this->studentList->links() }}
    </div>

    <x-ui.modal title="{{ $modalTitle }}" id="student-form-modal" footerButton="{{ $footerButton }}" size="lg"
        formId="student-form" wire:ignore.self>
        @livewire(
            'admin.student.student-form',
            [
                'modalId' => 'student-form-modal',
                'student' => $id ?: null,
            ],
            key('student-form-' . $id)
        )
    </x-ui.modal>
</div>
