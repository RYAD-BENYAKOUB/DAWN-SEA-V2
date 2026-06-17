<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ds-btn ds-btn-primary']) }}>
    {{ $slot }}
</button>
