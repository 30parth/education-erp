<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Subject;

class SubjectDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $subjects = [];
    public function __construct($semesterId = null)
    {
        if ($semesterId) {
            $this->subjects = Subject::where('semester_id', $semesterId)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.subject-dropdown');
    }
}
