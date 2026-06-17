<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('patch')

        <div class="ds-input-group">
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" style="margin-top: 0.25rem;" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('name')" />
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
