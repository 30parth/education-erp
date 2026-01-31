@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Division" :options="$divisions"
    valueLabel="division_name" value="id" {{ $attributes }} />
