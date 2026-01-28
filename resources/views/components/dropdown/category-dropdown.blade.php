@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Category" :options="$categories" valueLabel="name"
    value="id" {{ $attributes }} />
