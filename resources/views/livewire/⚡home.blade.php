<?php

use Livewire\Component;

new class extends Component {
    //

    public function handleClick()
    {
        dd('Primary');
    }

    public function save()
    {
        $this->dispatch('closeModal', modalId: 'testing-modal');
    }
};
?>
<div>
    <div class="p-4 sm:flex items-center justify-between border-b border-gray-200">
        <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
            <x-ui.button variant="primary" data-modal-target="testing-modal" data-modal-show="testing-modal">
                <div class="flex items-center">
                    <svg class="w-5 h-5 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add product
                </div>
            </x-ui.button>
        </div>
    </div>

    <x-ui.modal title="This is Rock" id="testing-modal" footerButton="Close Button">
        <div>
            <p>Modal content</p>
        </div>
    </x-ui.modal>
</div>
