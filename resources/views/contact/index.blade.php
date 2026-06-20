@extends('layouts.app')

@section('title', __('Contact & Équipe') . ' — Dawn & Sea')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(rgba(44, 44, 44, 0.5), rgba(44, 44, 44, 0.7)), url('https://images.unsplash.com/photo-1549487050-7164da2504ae?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover; padding: 120px 0 80px; text-align: center; color: var(--white);">
    <div class="ds-container">
        <h1 style="color: var(--white); font-size: 3.5rem; font-family: var(--font-serif); margin-bottom: 1rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
            {{ __('À Propos & Contact') }}
        </h1>
        <p style="color: var(--cream-dark); max-width: 600px; margin: 0 auto; font-size: 1.15rem; text-shadow: 0 1px 4px rgba(0,0,0,0.3);">
            {{ __('Découvrez l\'histoire de Dawn & Sea et rencontrez l\'équipe fondatrice.') }}
        </p>
    </div>
</div>

<div class="ds-container" style="padding: 4rem 2rem; max-width: 1200px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; align-items: start;">
        
        <!-- Description du Projet -->
        <div class="ds-animate-in">
            <h2 style="font-size: 2rem; margin-bottom: 1.5rem; color: var(--gold-dark);">{{ __('Notre Vision') }}</h2>
            <div style="color: var(--charcoal-soft); font-size: 1.05rem; line-height: 1.8;">
                <p style="margin-bottom: 1rem;">
                    <strong>Dawn & Sea</strong> est né d'une passion profonde pour le patrimoine, la culture et la diversité des paysages algériens. Notre objectif est de réinventer l'expérience touristique en Algérie en proposant une plateforme moderne, fiable et inspirante.
                </p>
                <p style="margin-bottom: 1rem;">
                    Que vous soyez à la recherche des plages immaculées de la Méditerranée ou des majestueuses dunes dorées du Sahara, nous vous connectons avec les meilleurs guides locaux certifiés pour des aventures inoubliables.
                </p>
                <p>
                    Notre plateforme permet non seulement aux voyageurs de planifier leurs séjours en toute simplicité, mais offre également aux professionnels du tourisme une vitrine digitale élégante pour mettre en valeur leur savoir-faire.
                </p>
            </div>
        </div>

        <!-- Profils de l'Équipe -->
        <div class="ds-animate-in" style="background: var(--white); padding: 3rem; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); border: 1px solid rgba(168,155,138,0.12);">
            <h3 style="font-size: 1.5rem; margin-bottom: 2rem; text-align: center; border-bottom: 2px solid var(--cream-dark); padding-bottom: 1rem;">{{ __('Fondateur & Superadmin') }}</h3>
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem auto; border: 4px solid var(--gold-glow); box-shadow: var(--shadow-md);">
                    @php
                        $userAvatar = App\Models\User::where('email', 'ryadbenyakoub@gmail.com')->first()?->avatar;
                    @endphp
                    @if($userAvatar)
                        <img src="data:image/jpeg;base64,{{ base64_encode($userAvatar) }}" alt="Ryad Benyakoub" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name=Ryad+Benyakoub&background=C5A880&color=fff&size=150" alt="Ryad Benyakoub" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <h4 style="font-size: 1.5rem; margin-bottom: 0.25rem;">Mohammed Ryad Benyakoub</h4>
                <div style="color: var(--gold); font-weight: 600; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em;">Développeur Full-Stack</div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem; color: var(--charcoal-soft);">
                <a href="mailto:ryadbenyakoub@gmail.com" class="ds-btn ds-btn-secondary" style="width: 100%; justify-content: flex-start; padding: 0.75rem 1.5rem;">
                    📧 ryadbenyakoub@gmail.com
                </a>
                <a href="https://github.com/RYAD-BENYAKOUB" target="_blank" class="ds-btn ds-btn-secondary" style="width: 100%; justify-content: flex-start; padding: 0.75rem 1.5rem;">
                    💻 GitHub Profile
                </a>
                <a href="https://www.linkedin.com/in/mohammed-ryad-benyakoub-0b16bb343?utm_source=share_via&utm_content=profile&utm_medium=member_android" target="_blank" class="ds-btn ds-btn-secondary" style="width: 100%; justify-content: flex-start; padding: 0.75rem 1.5rem;">
                    💼 LinkedIn
                </a>
                <a href="https://www.instagram.com/ryad_benyakoub?igsh=N3ZjYTF0aDBneGJw" target="_blank" class="ds-btn ds-btn-secondary" style="width: 100%; justify-content: flex-start; padding: 0.75rem 1.5rem;">
                    📸 Instagram
                </a>
                <a href="https://www.facebook.com/share/1D6UrimVd6/" target="_blank" class="ds-btn ds-btn-secondary" style="width: 100%; justify-content: flex-start; padding: 0.75rem 1.5rem;">
                    📘 Facebook
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
