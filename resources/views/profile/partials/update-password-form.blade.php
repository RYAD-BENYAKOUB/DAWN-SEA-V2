<section>
    <form method="post" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('put')

        <div class="ds-input-group">
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" style="margin-top: 0.25rem;" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" style="margin-top: 0.5rem;" />
        </div>

        <div class="ds-input-group">
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="update_password_password" name="password" type="password" style="margin-top: 0.25rem;" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" style="margin-top: 0.5rem;" />
        </div>

        <div class="ds-input-group">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" style="margin-top: 0.25rem;" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" style="margin-top: 0.5rem;" />
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 0.875rem; color: var(--success); margin: 0;"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
