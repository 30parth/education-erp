<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\On;

trait HasRefreshListener
{
    #[On('refresh')]
    public function refresh()
    {
        // Calling this public method will trigger a component re-render
    }
}
