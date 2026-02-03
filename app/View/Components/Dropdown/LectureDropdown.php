<?php

namespace App\View\Components\dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\TimeTable;
use App\Models\Teacher;
use Carbon\Carbon;

class LectureDropdown extends Component
{
    /**
     * Create a new component instance.
     */

    public $lectures = [];

    public function __construct($date = null)
    {
        if (!$date) {
            return;
        }

        $teacher = Teacher::where('user_id', Auth::user()->id)->first();

        $day = Carbon::parse($date)->format('l');

        $day = strtolower($day);

        $lectures = TimeTable::where('teacher_id', $teacher->id)->where('day', $day)->get();

        foreach ($lectures as $lecture) {
            $this->lectures[] = [
                'id' => $lecture->lecture_code,
                'name' => $lecture->subject->subject_name . ' - ' . $lecture->semester->semester_name . ' ( ' . $lecture->division->division_name . ' ) ' . $lecture->start_time . ' - ' . $lecture->end_time,
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.lecture-dropdown');
    }
}
