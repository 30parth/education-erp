@props([
    'id' => 'default-modal',
    'title' => 'Terms of Service',
    'footer' => true,
    'size' => 'md',
    'formId' => 'default-form',
    'footerButton' => 'Save',
])

@php
    $size = match ($size) {
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-4xl',
        'xl' => 'max-w-7xl',
        default => 'max-w-lg',
    };
@endphp

<!-- Main modal -->
<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    {{ $attributes->merge(['class' => 'hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full']) }}>
    <div class="relative p-4 w-full {{ $size }} max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    {{ $title }}
                </h3>
                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="{{ $id }}">
                    <x-ui.icon.close />
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="py-4">
                {{ $slot }}
            </div>
            @if ($footer)
                <!-- Modal footer -->
                <div class="flex items-center border-t border-default space-x-4 gap-2 p-2 md:p-3">
                    <button type="submit" form="{{ $formId }}"
                        class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        {{ $footerButton }}</button>

                    <button data-modal-hide="{{ $id }}" type="button"
                        class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        Cancel
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
