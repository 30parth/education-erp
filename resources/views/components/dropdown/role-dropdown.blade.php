@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Role" :options="$roles" valueLabel="name"
    value="id" {{ $attributes }} />
