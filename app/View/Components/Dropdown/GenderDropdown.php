<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GenderDropdown extends Component
{
    public $genders = [
        ['id' => 'Male', 'name' => 'Male'],
        ['id' => 'Female', 'name' => 'Female'],
        ['id' => 'Other', 'name' => 'Other'],
    ];

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dropdown.gender-dropdown');
    }
}
