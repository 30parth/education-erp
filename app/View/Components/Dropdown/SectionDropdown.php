<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionDropdown extends Component
{
    public $sections = [
        ['id' => 'A', 'name' => 'A'],
        ['id' => 'B', 'name' => 'B'],
        ['id' => 'C', 'name' => 'C'],
        ['id' => 'D', 'name' => 'D'],
    ];

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dropdown.section-dropdown');
    }
}
