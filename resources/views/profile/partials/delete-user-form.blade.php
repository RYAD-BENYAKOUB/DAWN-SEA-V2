<section>
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Supprimer le compte') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 2.5rem; background: var(--cream);">
            @csrf
            @method('delete')

            <h2 style="font-family: var(--font-serif); font-size: 1.5rem; color: var(--charcoal); margin-bottom: 0.75rem;">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p style="font-size: 0.9rem; color: var(--charcoal-soft); margin-bottom: 1.5rem; line-height: 1.6;">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer la suppression définitive de votre compte.') }}
            </p>

            <div class="ds-input-group" style="margin-bottom: 2rem;">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" style="margin-bottom: 0.5rem;" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Saisissez votre mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" style="margin-top: 0.5rem;" />
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Supprimer définitivement') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
