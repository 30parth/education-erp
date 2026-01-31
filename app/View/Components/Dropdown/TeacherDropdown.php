<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Teacher;

class TeacherDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $teachers;
    public function __construct()
    {
        $this->teachers = Teacher::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.teacher-dropdown');
    }
}
