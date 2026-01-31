@props([
    'id' => '',
    'name' => '',
    'label' => 'Week Day',
    'attributes' => [],
])

@php
    $weekDays = [
        ['id' => 'monday', 'name' => 'Monday'],
        ['id' => 'tuesday', 'name' => 'Tuesday'],
        ['id' => 'wednesday', 'name' => 'Wednesday'],
        ['id' => 'thursday', 'name' => 'Thursday'],
        ['id' => 'friday', 'name' => 'Friday'],
        ['id' => 'saturday', 'name' => 'Saturday'],
        ['id' => 'sunday', 'name' => 'Sunday'],
    ];
@endphp

<x-ui.form.select-with-label :id="$id" :name="$name" :label="$label" :options="$weekDays" valueLabel="name"
    value="id" {{ $attributes }} />
