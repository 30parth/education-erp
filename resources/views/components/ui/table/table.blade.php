<div class="overflow-x-auto shadow-xs rounded-base border border-default">
    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left']) }}>
        {{ $slot }}
    </table>
</div>
