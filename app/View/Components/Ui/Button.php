<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $variant;
    public string $size;
    public string $type;

    /**
     * Create a new component instance.
     */
    public function __construct(string $variant = 'primary', string $size = 'md', string $type = 'button')
    {
        $this->variant = $variant;
        $this->size = $size;
        $this->type = $type;
    }

    public function classes(): string
    {
        $baseClasses = 'box-border border shadow-xs font-medium leading-5 rounded-base  focus:outline-none transition ease-in-out duration-150';

        $variants = [
            'primary' => 'text-white bg-brand border-transparent hover:bg-brand-strong ',
            'secondary' => 'text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading ',
            'tertiary' => 'text-body bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium hover:text-heading ',
            'success' => 'text-white bg-success border-transparent hover:bg-success-strong ',
            'danger' => 'text-white bg-danger border-transparent hover:bg-danger-strong ',
            'warning' => 'text-white bg-warning border-transparent hover:bg-warning-strong ',
            'dark' => 'text-white bg-dark border-transparent hover:bg-dark-strong ',
            'ghost' => 'text-heading bg-transparent border-transparent hover:bg-neutral-secondary-medium ',
        ];

        $sizes = [
            'sm' => 'text-xs px-3 py-2',
            'md' => 'text-sm px-4 py-2.5',
            'lg' => 'text-base px-5 py-3',
        ];

        $variantClasses = $variants[$this->variant] ?? $variants['primary'];
        $sizeClasses = $sizes[$this->size] ?? $sizes['md'];

        return " {$baseClasses} {$variantClasses} {$sizeClasses} ";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button');
    }
}
