@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Lecture" :options="$lectures" valueLabel="name"
    value="id" {{ $attributes }} />
