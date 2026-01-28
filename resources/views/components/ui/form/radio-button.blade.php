@props([
    'name' => 'defaultName',
    'options' => [],
])
<div class="flex flex-col gap-2">
    @foreach ($options as $option)
        <div class="flex items-center ps-4 border border-default bg-neutral-primary-soft rounded-base">
            <input id="bordered-radio-{{ $option['value'] }}" type="radio" wire:model="{{ $name }}"
                value="{{ $option['value'] }}" name="{{ $name }}"
                class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
            <label for="bordered-radio-{{ $option['value'] }}"
                class="w-full py-4 select-none ms-2 text-sm font-medium text-heading">{{ $option['label'] }}</label>
        </div>
    @endforeach
</div>
