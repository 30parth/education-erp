<?php

use Livewire\Component;
use App\Models\Student;
use App\Models\Teacher;

new class extends Component {
    public function with()
    {
        return [
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'recentStudents' => Student::latest()->take(5)->get(),
            'recentTeachers' => Teacher::latest()->take(5)->get(),
        ];
    }
    public function goToStudentList()
    {
        return redirect()->route('admin.student.list');
    }
    public function goToTeacherList()
    {
        return redirect()->route('admin.teacher.list');
    }
};
?>

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <!-- Stats Grid -->
    <!-- Stats Grid -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <!-- Students Card -->
        <div
            class="w-1/2 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Students</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400 text-4xl">{{ $totalStudents }}</p>
            </div>
            <x-ui.button variant="secondary" class="inline-flex gap-2" wire:click="goToStudentList">
                View All
                <x-ui.icon.arrow-right />
            </x-ui.button>
        </div>

        <!-- Teachers Card -->
        <div
            class="w-1/2 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Teachers</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400 text-4xl">{{ $totalTeachers }}</p>
            </div>
            <x-ui.button variant="secondary" class="inline-flex gap-2" wire:click="goToTeacherList">
                View All
                <x-ui.icon.arrow-right />
            </x-ui.button>
        </div>
    </div>

    <!-- Recent Lists Grid -->
    <!-- Recent Lists Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
        <!-- Recent Students -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Students</h2>
            <x-ui.table.table>
                <x-ui.table.head>
                    <tr>
                        <x-ui.table.th>Name</x-ui.table.th>
                        <x-ui.table.th>Email</x-ui.table.th>
                        <x-ui.table.th>Admission No</x-ui.table.th>
                    </tr>
                </x-ui.table.head>
                <x-ui.table.body>
                    @foreach ($recentStudents as $student)
                        <x-ui.table.row>
                            <x-ui.table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $student->name }}
                            </x-ui.table.td>
                            <x-ui.table.td>
                                {{ $student->email }}
                            </x-ui.table.td>
                            <x-ui.table.td>
                                {{ $student->admission_no }}
                            </x-ui.table.td>
                        </x-ui.table.row>
                    @endforeach
                </x-ui.table.body>
            </x-ui.table.table>
        </div>

        <!-- Recent Teachers -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Teachers</h2>
            <x-ui.table.table>
                <x-ui.table.head>
                    <tr>
                        <x-ui.table.th>Name</x-ui.table.th>
                        <x-ui.table.th>Email</x-ui.table.th>
                        <x-ui.table.th>Staff ID</x-ui.table.th>
                    </tr>
                </x-ui.table.head>
                <x-ui.table.body>
                    @foreach ($recentTeachers as $teacher)
                        <x-ui.table.row>
                            <x-ui.table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $teacher->name }}
                            </x-ui.table.td>
                            <x-ui.table.td>
                                {{ $teacher->email }}
                            </x-ui.table.td>
                            <x-ui.table.td>
                                {{ $teacher->staff_id }}
                            </x-ui.table.td>
                        </x-ui.table.row>
                    @endforeach
                </x-ui.table.body>
            </x-ui.table.table>
        </div>
    </div>
</div>
