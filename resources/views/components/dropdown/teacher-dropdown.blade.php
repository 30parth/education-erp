@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Teacher" :options="$teachers" valueLabel="name"
    value="id" {{ $attributes }} />
