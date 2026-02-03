<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $menuItems = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();
        $role = $user ? $user->role : 'guest';

        $this->menuItems = match ($role) {
            'admin' => $this->adminMenu(),
            'teacher' => $this->teacherMenu(),
            'student' => $this->studentMenu(),
            default => [],
        };
    }

    private function adminMenu(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => 'admin.dashboard',
                'icon' => 'ui.icon.dashboard',
            ],
            [
                'label' => 'Academic',
                'url' => '#',
                'icon' => 'ui.icon.home',
                'children' => [
                    [
                        'label' => 'Semester',
                        'url' => 'admin.semester.list',
                    ],
                    [
                        'label' => 'Subject',
                        'url' => 'admin.subject.list',
                    ],
                    [
                        'label' => 'Division',
                        'url' => 'admin.division.list',
                    ]
                ]
            ],
            [
                'label' => "Student",
                'url' => 'admin.student.list',
                'icon' => 'ui.icon.user'
            ],
            [
                'label' => "Teacher",
                'url' => 'admin.teacher.list',
                'icon' => 'ui.icon.user-group'
            ],
            [
                'label' => "Time Table",
                'url' => '#',
                'icon' => 'ui.icon.table',
                'children' => [
                    [
                        'label' => 'View Time Table',
                        'url' => 'admin.timetable.list',
                    ],
                    [
                        'label' => 'Create Time Table',
                        'url' => 'admin.timetable.create',
                    ]
                ]
            ]
        ];
    }

    private function teacherMenu(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => 'teacher.dashboard',
                'icon' => 'ui.icon.dashboard',
            ],
            [
                'label' => 'Student',
                'url' => 'teacher.student.list',
                'icon' => 'ui.icon.user'
            ],
            [
                'label' => 'Time Table',
                'url' => 'teacher.timetable.view',
                'icon' => 'ui.icon.table'
            ],
            [
                'label' => 'Attendance',
                'url' => 'teacher.attendance.create',
                'icon' => 'ui.icon.calender'
            ]
        ];
    }

    private function studentMenu(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => 'student.dashboard',
                'icon' => 'ui.icon.dashboard',
            ],
            [
                'label' => 'Time Table',
                'url' => 'student.timetable.view',
                'icon' => 'ui.icon.table'
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.sidebar');
    }
}
