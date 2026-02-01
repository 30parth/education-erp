@props(['id', 'modalId' => 'defaultModal'])
<div class="inline-flex  justify-between">
    <button type='button' wire:click="$set('id',{{ $id }})" data-modal-target="{{ $modalId }}"
        data-modal-show="{{ $modalId }}" wire:ignore.self>
        <x-ui.icon.edit />
    </button>
    <div wire:click="delete({{ $id }})" wire:confirm="Are you want to delete this ?">
        <x-ui.icon.trash />
    </div>

</div>
