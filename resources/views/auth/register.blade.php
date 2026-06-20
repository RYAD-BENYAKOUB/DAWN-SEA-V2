<x-guest-layout>
    <h2 class="ds-auth-title">{{ __('Créer un compte') }}</h2>
    <p class="ds-auth-subtitle">{{ __('Rejoignez Dawn & Sea et explorez l\'Algérie') }}</p>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Prénom & Nom -->
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="flex: 1;">
                <label for="first_name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Prénom') }}</label>
                <input id="first_name" class="ds-input" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" placeholder="Votre prénom" />
                <x-input-error :messages="$errors->get('first_name')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
            <div style="flex: 1;">
                <label for="last_name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Nom') }}</label>
                <input id="last_name" class="ds-input" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Votre nom" />
                <x-input-error :messages="$errors->get('last_name')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="ds-input-group">
            <label for="email" class="ds-label">{{ __('Email') }}</label>
            <input id="email" class="ds-input @error('email') ds-input-error @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com">
            @error('email')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Téléphone & Date de naissance -->
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="flex: 1;">
                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Téléphone (Optionnel)') }}</label>
                <input id="phone" class="ds-input" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="+213..." />
                <x-input-error :messages="$errors->get('phone')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
            <div style="flex: 1;">
                <label for="birth_date" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Date de naissance (Optionnel)') }}</label>
                <input id="birth_date" class="ds-input" type="date" name="birth_date" value="{{ old('birth_date') }}" />
                <x-input-error :messages="$errors->get('birth_date')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
        </div>

        <!-- Pays de naissance & Avatar -->
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="flex: 1;">
                <label for="country_of_birth" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Pays de naissance (Optionnel)') }}</label>
                <input id="country_of_birth" class="ds-input" type="text" name="country_of_birth" value="{{ old('country_of_birth') }}" placeholder="Ex: Algérie" />
                <x-input-error :messages="$errors->get('country_of_birth')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
            <div style="flex: 1;">
                <label for="avatar" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">{{ __('Photo de profil (Optionnelle)') }}</label>
                <input id="avatar" class="ds-input" type="file" name="avatar" accept="image/*" style="padding: 0.6rem 1rem;" />
                <x-input-error :messages="$errors->get('avatar')" style="color: var(--error); font-size: 0.85rem; margin-top: 0.25rem;" />
            </div>
        </div>

        <!-- Role Selection -->
        <div class="ds-input-group">
            <label class="ds-label">{{ __('Je suis') }}</label>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                <label style="display:flex; align-items:center; gap:0.75rem; padding:0.875rem 1rem; border:1.5px solid var(--taupe-lighter); border-radius:var(--radius-sm); cursor:pointer; transition:all 0.2s;" onclick="this.querySelector('input').checked=true; this.style.borderColor='var(--gold)'; this.style.background='var(--gold-glow)'; this.parentElement.children[1].style.borderColor='var(--taupe-lighter)'; this.parentElement.children[1].style.background='transparent';">
                    <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }} style="accent-color:var(--gold);">
                    <div>
                        <div style="font-weight:600; font-size:0.9rem; color:var(--charcoal);">🌍 {{ __('Voyageur') }}</div>
                        <div style="font-size:0.75rem; color:var(--taupe);">{{ __('Explorer & réserver') }}</div>
                    </div>
                </label>
                <label style="display:flex; align-items:center; gap:0.75rem; padding:0.875rem 1rem; border:1.5px solid var(--taupe-lighter); border-radius:var(--radius-sm); cursor:pointer; transition:all 0.2s;" onclick="this.querySelector('input').checked=true; this.style.borderColor='var(--gold)'; this.style.background='var(--gold-glow)'; this.parentElement.children[0].style.borderColor='var(--taupe-lighter)'; this.parentElement.children[0].style.background='transparent';">
                    <input type="radio" name="role" value="guide" {{ old('role') === 'guide' ? 'checked' : '' }} style="accent-color:var(--gold);">
                    <div>
                        <div style="font-weight:600; font-size:0.9rem; color:var(--charcoal);">🧭 {{ __('Guide') }}</div>
                        <div style="font-size:0.75rem; color:var(--taupe);">{{ __('Proposer des programmes') }}</div>
                    </div>
                </label>
            </div>
            @error('role')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="ds-input-group">
            <label for="password" class="ds-label">{{ __('Mot de passe') }}</label>
            <input id="password" class="ds-input @error('password') ds-input-error @enderror" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @error('password')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="ds-input-group">
            <label for="password_confirmation" class="ds-label">{{ __('Confirmer le mot de passe') }}</label>
            <input id="password_confirmation" class="ds-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
        </div>

        <!-- Submit -->
        <button type="submit" class="ds-btn ds-btn-primary" style="width:100%; padding:0.875rem;">
            {{ __('Créer mon compte') }}
        </button>
    </form>

    <div class="ds-auth-footer">
        {{ __('Déjà inscrit ?') }}
        <a href="{{ route('login') }}">{{ __('Se connecter') }}</a>
    </div>
</x-guest-layout>
