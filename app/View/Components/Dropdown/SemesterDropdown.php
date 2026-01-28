<?php

namespace App\View\Components\Dropdown;

use App\Models\Semester;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SemesterDropdown extends Component
{

    public $semesters;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->semesters = Semester::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.semester-dropdown');
    }
}
