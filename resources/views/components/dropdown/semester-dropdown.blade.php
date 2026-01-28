@props([
    'id' => '',
    'name' => '',
    'attributes' => [],
])

<x-ui.form.select-with-label :id="$id" :name="$name" label="Semester" :options="$semesters"
    valueLabel="semester_name" value="id" {{ $attributes }} />
