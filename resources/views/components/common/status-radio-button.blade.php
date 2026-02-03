@props([
    'name' => 'defaultName',
])
<x-ui.form.radio-button name="{{ $name }}" :options="$options" orientation="horizontal" />
