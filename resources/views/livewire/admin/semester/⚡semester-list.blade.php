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

    #[Computed]
    public function semesterList()
    {
        return Semester::where('semester_name', 'like', '%' . $this->search . '%')
            ->where('semester_code', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }
};
?>

<div class="p-4">
    <div class="w-full">
        <div class="flex flex-col items-center justify-between  space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <x-common.search-filter />
            <div
                class="flex flex-col  justify-end w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <x-ui.button data-modal-target="semester-form-modal" data-modal-show="semester-form-modal">
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
                    <x-ui.table.th>
                        <span class="sr-only">Edit</span>
                    </x-ui.table.th>
                </tr>
            </x-ui.table.head>
            <x-ui.table.body>
                @foreach ($this->semesterList as $index => $semester)
                    <x-ui.table.row>
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
                            <a href="#" class="font-medium text-fg-brand hover:underline">Edit</a>
                        </x-ui.table.td>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>

        {{ $this->semesterList->links() }}

    </div>

    <x-ui.modal title="Create Semester" id="semester-form-modal" footerButton="Save" size="md"
        formId="semester-form">
        @livewire('admin.semester.semester-form', ['modalId' => 'semester-form-modal'])
    </x-ui.modal>
</div>
