<tr
    {{ $attributes->merge([
        'class' => 'bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium',
    ]) }}>
    {{ $slot }}
</tr>
