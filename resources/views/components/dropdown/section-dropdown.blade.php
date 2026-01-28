@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Section" :options="$sections" valueLabel="name"
    value="id" {{ $attributes }} />
