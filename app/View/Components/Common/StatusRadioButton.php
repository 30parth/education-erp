<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusRadioButton extends Component
{
    public $options;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->options = [
            ['label' => 'Active', 'value' => 1],
            ['label' => 'Inactive', 'value' => 0],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.status-radio-button');
    }
}
