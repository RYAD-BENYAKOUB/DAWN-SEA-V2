<x-guest-layout>
    <h2 class="ds-auth-title">{{ __('Créer un compte') }}</h2>
    <p class="ds-auth-subtitle">{{ __('Rejoignez Dawn & Sea et explorez l\'Algérie') }}</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="ds-input-group">
            <label for="name" class="ds-label">{{ __('Nom complet') }}</label>
            <input id="name" class="ds-input @error('name') ds-input-error @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Votre nom') }}">
            @error('name')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="ds-input-group">
            <label for="email" class="ds-label">{{ __('Email') }}</label>
            <input id="email" class="ds-input @error('email') ds-input-error @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com">
            @error('email')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
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
