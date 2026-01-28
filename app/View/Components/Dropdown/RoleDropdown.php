<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RoleDropdown extends Component
{
    public $roles = [
        ['id' => 'Teacher', 'name' => 'Teacher'],
        ['id' => 'Admin', 'name' => 'Admin'],
        ['id' => 'Staff', 'name' => 'Staff'],
    ];

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dropdown.role-dropdown');
    }
}
