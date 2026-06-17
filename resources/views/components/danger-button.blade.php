<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ds-btn ds-btn-danger']) }}>
    {{ $slot }}
</button>
