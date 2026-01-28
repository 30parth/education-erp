<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    public $categories = [
        ['id' => 'General', 'name' => 'General'],
        ['id' => 'OBC', 'name' => 'OBC'],
        ['id' => 'SC', 'name' => 'SC'],
        ['id' => 'ST', 'name' => 'ST'],
        ['id' => 'EWS', 'name' => 'EWS'],
    ];

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.dropdown.category-dropdown');
    }
}
