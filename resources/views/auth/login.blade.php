<x-guest-layout>
    <h2 class="ds-auth-title">{{ __('Bienvenue') }}</h2>
    <p class="ds-auth-subtitle">{{ __('Connectez-vous à votre espace Dawn & Sea') }}</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="ds-input-group">
            <label for="email" class="ds-label">{{ __('Email') }}</label>
            <input id="email" class="ds-input @error('email') ds-input-error @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="votre@email.com">
            @error('email')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="ds-input-group">
            <label for="password" class="ds-label">{{ __('Mot de passe') }}</label>
            <input id="password" class="ds-input @error('password') ds-input-error @enderror" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <p class="ds-error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot -->
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <label for="remember_me" style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input id="remember_me" type="checkbox" class="ds-checkbox" name="remember">
                <span style="font-size:0.85rem; color:var(--charcoal-soft);">{{ __('Se souvenir') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.85rem; color:var(--gold); font-weight:500;">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="ds-btn ds-btn-primary" style="width:100%; padding:0.875rem;">
            {{ __('Se connecter') }}
        </button>
    </form>

    <div class="ds-auth-footer">
        {{ __('Pas encore de compte ?') }}
        <a href="{{ route('register') }}">{{ __('Créer un compte') }}</a>
    </div>
</x-guest-layout>
