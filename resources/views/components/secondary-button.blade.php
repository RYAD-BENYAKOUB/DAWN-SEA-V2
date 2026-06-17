<button {{ $attributes->merge(['type' => 'button', 'class' => 'ds-btn ds-btn-secondary']) }}>
    {{ $slot }}
</button>
