<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BloodGroupDropdown extends Component
{
    public $bloodGroups = [
        ['id' => 'A+', 'name' => 'A+'],
        ['id' => 'A-', 'name' => 'A-'],
        ['id' => 'B+', 'name' => 'B+'],
        ['id' => 'B-', 'name' => 'B-'],
        ['id' => 'AB+', 'name' => 'AB+'],
        ['id' => 'AB-', 'name' => 'AB-'],
        ['id' => 'O+', 'name' => 'O+'],
        ['id' => 'O-', 'name' => 'O-'],
    ];

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dropdown.blood-group-dropdown');
    }
}
