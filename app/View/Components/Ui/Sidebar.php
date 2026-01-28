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
                'url' => '/admin',
                'icon' => '<svg class="w-6 h-6 text-gray-800 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                           </svg>',
            ],
            [
                'label' => 'Academic',
                'url' => '#',
                'icon' => '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
</svg>
',
                'children' => [
                    [
                        'label' => 'Semester',
                        'url' => '/admin/semester',
                    ],
                    [
                        'label' => 'Subject',
                        'url' => '/admin/subject',
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
                'url' => '#',
                'icon' => '<svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                           </svg>',
            ],
        ];
    }

    private function studentMenu(): array
    {
        return [
            [
                'label' => 'Sign Up',
                'url' => '#',
                'icon' => '<svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                           </svg>',
            ],
            [
                'label' => 'My Grades',
                'url' => '#',
                'icon' => '<svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z"/>
                           </svg>',
            ],
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
