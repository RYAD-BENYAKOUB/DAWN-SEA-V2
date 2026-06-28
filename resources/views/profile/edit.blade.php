<x-app-layout>
    @section('title', __('Mon Profil') . ' — Dawn & Sea')

    <div class="ds-container" style="padding-top: 120px; padding-bottom: 60px; min-height: 100vh;">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 2.5rem; align-items: start;">
            
            <!-- Profile Sidebar / Quick Card -->
            <div class="ds-card-static" style="background: var(--white); padding: 2.5rem 2rem; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                @if($user->avatar && is_string($user->avatar) && str_starts_with($user->avatar, 'avatars/'))
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold); margin: 0 auto 1.5rem; display: block;">
                @else
                    <div class="ds-sidebar-avatar-placeholder" style="width: 96px; height: 96px; font-size: 2.25rem; margin: 0 auto 1.5rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                
                <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; font-family: var(--font-serif); color: var(--charcoal);">
                    {{ $user->name }}
                </h2>
                
                <p style="font-size: 0.875rem; color: var(--taupe); margin-bottom: 1.5rem;">
                    {{ $user->email }}
                </p>

                <div style="margin-bottom: 1.5rem;">
                    @if($user->isSuperadmin())
                        <span class="ds-badge" style="font-size: 0.85rem; padding: 0.4rem 1rem; background: var(--charcoal); color: var(--gold);">
                            {{ __('SuperAdmin') }}
                        </span>
                    @elseif($user->isAdmin())
                        <span class="ds-badge" style="font-size: 0.85rem; padding: 0.4rem 1rem; background: var(--charcoal); color: var(--cream);">
                            {{ __('Administrateur') }}
                        </span>
                    @elseif($user->isGuide())
                        <span class="ds-badge ds-badge-gold" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                            {{ __('Guide Touristique') }}
                        </span>
                    @else
                        <span class="ds-badge ds-badge-taupe" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                            {{ __('Voyageur') }}
                        </span>
                    @endif
                </div>

                <hr style="border: 0; border-top: 1px solid rgba(168, 155, 138, 0.15); margin: 1.5rem 0;">

                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @if($user->isAdmin() || $user->isGuide())
                        <a href="{{ url('/dashboard') }}" class="ds-btn ds-btn-primary ds-btn-sm" style="width: 100%;">
                            {{ __('Accéder au Dashboard') }}
                        </a>
                    @endif
                    <a href="{{ url('/') }}" class="ds-btn ds-btn-ghost ds-btn-sm" style="width: 100%;">
                        {{ __('Retour à l\'accueil') }}
                    </a>
                </div>
            </div>

            <!-- Profile Settings Forms -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Update Profile Info Card -->
                <div class="ds-card-static" style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden;">
                    <div style="padding: 2rem; border-bottom: 1px solid rgba(168, 155, 138, 0.15);">
                        <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--charcoal); margin: 0;">
                            {{ __('Informations Personnelles') }}
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--taupe); margin: 0.25rem 0 0 0;">
                            {{ __('Mettez à jour les informations de votre profil et votre adresse e-mail.') }}
                        </p>
                    </div>
                    <div style="padding: 2rem;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="ds-card-static" style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden;">
                    <div style="padding: 2rem; border-bottom: 1px solid rgba(168, 155, 138, 0.15);">
                        <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--charcoal); margin: 0;">
                            {{ __('Changer le Mot de Passe') }}
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--taupe); margin: 0.25rem 0 0 0;">
                            {{ __('Assurez-vous d\'utiliser un mot de passe long et aléatoire pour garantir la sécurité de votre compte.') }}
                        </p>
                    </div>
                    <div style="padding: 2rem;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="ds-card-static" style="background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden;">
                    <div style="padding: 2rem; border-bottom: 1px solid rgba(168, 155, 138, 0.15);">
                        <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--error); margin: 0;">
                            {{ __('Supprimer le Compte') }}
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--taupe); margin: 0.25rem 0 0 0;">
                            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.') }}
                        </p>
                    </div>
                    <div style="padding: 2rem;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>

        </div>

        <!-- Favorites Section -->
        @php
            $user->load('favoritePrograms');
        @endphp
        @if($user->favoritePrograms->isNotEmpty())
            <div style="margin-top: 4rem; padding-top: 3rem; border-top: 1px solid rgba(168, 155, 138, 0.2);">
                <h2 style="font-family: var(--font-serif); font-size: 2rem; color: var(--charcoal); margin-bottom: 2rem; text-align: center;">
                    {{ __('Mes Programmes Favoris') }}
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($user->favoritePrograms as $program)
                        <div class="ds-card">
                            @php
                                $imgUrl = $program->image ? asset($program->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                            @endphp
                            <div style="position: relative;">
                                <img src="{{ $imgUrl }}" alt="{{ $program->title }}" class="ds-card-img" style="height: 180px; object-fit: cover;">
                                <div style="position: absolute; top: 1rem; left: 1rem; z-index: 10;">
                                    <span class="ds-badge ds-badge-gold" style="font-size: 0.7rem;">
                                        {{ $program->location }}
                                    </span>
                                </div>
                            </div>
                            <div class="ds-card-body">
                                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--charcoal); margin-bottom: 0.5rem; line-height: 1.3;">
                                    {{ Str::limit($program->title, 50) }}
                                </h3>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <span style="font-size: 0.8rem; color: var(--taupe);">
                                        ⏳ {{ $program->duration }}
                                    </span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="ds-price" style="font-size: 1.15rem;">{{ number_format($program->price, 0, ',', ' ') }} DA</span>
                                    <a href="{{ route('programs.show', $program->slug) }}" class="ds-btn ds-btn-primary ds-btn-sm" style="padding: 0.4rem 1rem;">
                                        {{ __('Voir') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
