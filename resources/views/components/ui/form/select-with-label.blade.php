@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'valueLabel' => 'name',
    'value' => 'id',
    'options' => [],
])
<div class="">
    @if (!$attributes->has('no-label'))
        <label for="{{ $id }}" class="block mb-2.5 text-sm font-medium text-heading">{{ $label }}</label>
    @endif
    <select id="{{ $id }}"
        @if ($attributes->has('is-live')) wire:model.live="{{ $name }}"
        @else
            wire:model="{{ $name }}" @endif
        {{ $attributes->except('is-live') }}
        class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs placeholder:text-body
        {{ $errors->has($name)
            ? 'bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger'
            : 'bg-neutral-secondary-medium border-default-medium text-heading focus:ring-brand focus:border-brand' }}">

        <option value="">Select</option>
        @foreach ($options as $option)
            <option value="{{ $option[$value] }}">{{ $option[$valueLabel] }}</option>
        @endforeach
    </select>

    @error($name)
        <span class="text-sm text-fg-danger-strong">{{ $message }}</span>
    @enderror
</div>
