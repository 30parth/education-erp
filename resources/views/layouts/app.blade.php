@extends('components.layouts.layouts')

<x-ui.navbar />

<x-ui.sidebar />

@section('content')
    {{ $slot }}
@endsection

@push('scripts')
    <script>
        Livewire.on('closeModal', (data) => {

            const modalId = data.modalId;

            const closeButton = document.querySelector('[data-modal-hide="' + modalId + '"]');
            if (closeButton) {
                closeButton.click();
            }

            Livewire.dispatch('refresh');
        });

        document.addEventListener('livewire:navigated', () => {
            initFlowbite();
        });

        Livewire.on('refresh', () => {
            Livewire.dispatch('$refresh');
        });
    </script>
@endpush
