@props([
    'name' => 'defaultName',
    'options' => [],
    'orientation' => 'vertical',
])

<div class="flex {{ $orientation === 'horizontal' ? 'flex-row gap-4' : 'flex-col gap-2' }}">
    @foreach ($options as $option)
        @php
            $id = $name . '-' . $option['value'];
        @endphp
        <div class="relative flex items-center">
            <input class="peer sr-only" id="{{ $id }}" type="radio" value="{{ $option['value'] }}"
                name="{{ $name }}" wire:model="{{ $name }}" />
            <label
                class="flex cursor-pointer items-center rounded-base border border-neutral-200 px-4 py-2 text-sm font-medium text-neutral-600 transition-all hover:bg-neutral-50 peer-checked:border-brand peer-checked:bg-brand-soft peer-checked:text-brand peer-focus:ring-2 peer-focus:ring-brand-subtle"
                for="{{ $id }}">
                {{ $option['label'] }}
            </label>
        </div>
    @endforeach
</div>
