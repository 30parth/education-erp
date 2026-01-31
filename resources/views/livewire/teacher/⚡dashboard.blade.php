<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <h1 class="text-2xl font-bold mb-4">Teacher Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
</div>
