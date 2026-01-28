@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Gender" :options="$genders" valueLabel="name"
    value="id" {{ $attributes }} />
