@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Subject" :options="$subjects"
    valueLabel="subject_name" value="id" {{ $attributes }} />
