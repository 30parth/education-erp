@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Blood Group" :options="$bloodGroups" valueLabel="name"
    value="id" {{ $attributes }} />
