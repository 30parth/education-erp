<?php

namespace App\View\Components\Dropdown;

use App\Models\Semester;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DivisionDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $divisions = [];
    public function __construct($semesterId)
    {
        if (!$semesterId) {
            return;
        }
        $semester = Semester::find($semesterId);
        $this->divisions = $semester->divisions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.division-dropdown');
    }
}
