<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('patch')

        <div style="display: flex; gap: 1rem;">
            <div class="ds-input-group" style="flex: 1;">
                <x-input-label for="first_name" :value="__('Prénom')" />
                <x-text-input id="first_name" name="first_name" type="text" style="margin-top: 0.25rem;" :value="old('first_name', $user->first_name)" required autofocus autocomplete="given-name" />
                <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('first_name')" />
            </div>
            <div class="ds-input-group" style="flex: 1;">
                <x-input-label for="last_name" :value="__('Nom')" />
                <x-text-input id="last_name" name="last_name" type="text" style="margin-top: 0.25rem;" :value="old('last_name', $user->last_name)" required autocomplete="family-name" />
                <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="ds-input-group">
            <x-input-label for="avatar" :value="__('Photo de profil')" />
            <input id="avatar" name="avatar" type="file" accept="image/*" class="ds-input" style="margin-top: 0.25rem; padding: 0.5rem;" />
            <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('avatar')" />
        </div>

        <div style="display: flex; gap: 1rem;">
            <div class="ds-input-group" style="flex: 1;">
                <x-input-label for="phone" :value="__('Téléphone')" />
                <x-text-input id="phone" name="phone" type="tel" style="margin-top: 0.25rem;" :value="old('phone', $user->phone)" />
                <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('phone')" />
            </div>
            <div class="ds-input-group" style="flex: 1;">
                <x-input-label for="birth_date" :value="__('Date de naissance')" />
                <x-text-input id="birth_date" name="birth_date" type="date" style="margin-top: 0.25rem;" :value="old('birth_date', $user->birth_date)" />
                <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('birth_date')" />
            </div>
        </div>
        
        <div class="ds-input-group">
            <x-input-label for="country_of_birth" :value="__('Pays de naissance')" />
            <x-text-input id="country_of_birth" name="country_of_birth" type="text" style="margin-top: 0.25rem;" :value="old('country_of_birth', $user->country_of_birth)" />
            <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('country_of_birth')" />
        </div>

        <div class="ds-input-group">
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" name="email" type="email" style="margin-top: 0.25rem;" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 0.75rem;">
                    <p style="font-size: 0.875rem; color: var(--charcoal-soft);">
                        {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                        <button form="send-verification" style="background: transparent; border: none; color: var(--gold); text-decoration: underline; cursor: pointer; padding: 0;">
                            {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.875rem; color: var(--success);">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
