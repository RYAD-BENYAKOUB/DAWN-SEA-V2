@extends('layouts.app')

@section('title', 'Dawn & Sea — Tourisme de Luxe en Algérie')
@section('meta_description', 'Découvrez l\'Algérie authentique avec Dawn & Sea. Programmes touristiques de luxe, guides locaux certifiés, destinations exceptionnelles.')

@section('content')
<!-- Hero Section -->
<section class="ds-hero" id="hero">
    <div class="ds-hero-bg">
        <img src="{{ asset('storage/images/ALG.jfif') }}" alt="Algérie côte méditerranéenne" loading="eager">
    </div>
    <div class="ds-hero-overlay"></div>
    <div class="ds-hero-content ds-animate-in">
        <h1 class="ds-hero-title">
            {{ __('Découvrez l\'') }}<span class="ds-gold-text">{{ __('Algérie') }}</span> {{ __('Authentique') }}
        </h1>
        <p class="ds-hero-subtitle">
            {{ __('Explorez des paysages à couper le souffle, de la Méditerranée au Sahara, accompagnés par des guides locaux passionnés qui vous révèleront les trésors cachés de cette terre millénaire.') }}
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="{{ url('/programs') }}" class="ds-btn ds-btn-primary ds-btn-lg">
                {{ __('Explorer les programmes') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ url('/destinations') }}" class="ds-btn ds-btn-secondary" style="border-color:rgba(255,255,255,0.4); color:white;">
                {{ __('Nos destinations') }}
            </a>
        </div>
    </div>
</section>

<!-- Stats Band -->
<section style="background:var(--charcoal); padding:2.5rem 0;">
    <div class="ds-container">
        <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:2rem; text-align:center;">
            <div class="ds-animate-in ds-animate-delay-1">
                <div style="font-family:var(--font-serif); font-size:2.5rem; font-weight:700; color:var(--gold);">{{ $stats['programs'] ?? '50' }}+</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.05em;">{{ __('Programmes') }}</div>
            </div>
            <div class="ds-animate-in ds-animate-delay-2">
                <div style="font-family:var(--font-serif); font-size:2.5rem; font-weight:700; color:var(--gold);">{{ $stats['guides'] ?? '20' }}+</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.05em;">{{ __('Guides certifiés') }}</div>
            </div>
            <div class="ds-animate-in ds-animate-delay-3">
                <div style="font-family:var(--font-serif); font-size:2.5rem; font-weight:700; color:var(--gold);">{{ $stats['destinations'] ?? '15' }}+</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.05em;">{{ __('Destinations') }}</div>
            </div>
            <div class="ds-animate-in ds-animate-delay-4">
                <div style="font-family:var(--font-serif); font-size:2.5rem; font-weight:700; color:var(--gold);">{{ $stats['travelers'] ?? '500' }}+</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.05em;">{{ __('Voyageurs satisfaits') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Destinations Section -->
<section class="ds-section" id="destinations">
    <div class="ds-container">
        <div class="ds-section-header">
            <h2 class="ds-section-title">{{ __('Destinations d\'Exception') }}</h2>
            <p class="ds-section-subtitle">{{ __('Des côtes méditerranéennes aux dunes dorées du Sahara, chaque destination est une invitation au voyage.') }}</p>
            <div class="ds-section-divider"></div>
        </div>

        <div class="ds-grid-3">
            @php
                $destinations = [
                    ['name' => 'Casbah d\'Alger', 'desc' => 'Patrimoine UNESCO, ruelles ancestrales', 'img' => 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?w=600&q=80'],
                    ['name' => 'Tassili n\'Ajjer', 'desc' => 'Art rupestre & paysages lunaires', 'img' => 'https://images.unsplash.com/photo-1509023464722-18d996393ca8?w=600&q=80'],
                    ['name' => 'Tipaza', 'desc' => 'Ruines romaines face à la mer', 'img' => 'https://images.unsplash.com/photo-1504512485720-7d83a16ee930?w=600&q=80'],
                ];
            @endphp

            @foreach($destinations as $index => $dest)
                <div class="ds-destination-card ds-animate-in ds-animate-delay-{{ $index + 1 }}">
                    <img src="{{ $dest['img'] }}" alt="{{ $dest['name'] }}" loading="lazy">
                    <div class="ds-destination-overlay">
                        <span class="ds-badge ds-badge-gold" style="margin-bottom:0.5rem;">{{ __('Populaire') }}</span>
                        <h3>{{ $dest['name'] }}</h3>
                        <p>{{ $dest['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Programs -->
<section class="ds-section" style="background:var(--cream-dark);">
    <div class="ds-container">
        <div class="ds-section-header">
            <h2 class="ds-section-title">{{ __('Programmes Populaires') }}</h2>
            <p class="ds-section-subtitle">{{ __('Des expériences soigneusement conçues par nos guides locaux pour des moments inoubliables.') }}</p>
            <div class="ds-section-divider"></div>
        </div>

        <div class="ds-grid-3">
            @forelse($programs ?? [] as $program)
                <div class="ds-card" style="display: flex; flex-direction: column; height: 100%;">
                    <img src="{{ $program->image ? asset($program->image) : 'https://images.unsplash.com/photo-1504512485720-7d83a16ee930?w=600&q=80' }}" alt="{{ $program->title }}" class="ds-card-img" loading="lazy">
                    <div class="ds-card-body" style="display: flex; flex-direction: column; flex-grow: 1;">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                            <span class="ds-badge ds-badge-taupe">{{ $program->duration ?? '3 jours' }}</span>
                            <span class="ds-badge ds-badge-gold">{{ $program->difficulty ?? 'Modéré' }}</span>
                        </div>
                        <h3 class="ds-card-title">{{ $program->title }}</h3>
                        <p class="ds-card-text" style="margin-bottom:1rem; flex-grow: 1;">{{ Str::limit($program->description, 100) }}</p>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--taupe); display: block;">{{ __('À partir de') }}</span>
                                <span class="ds-price">{{ number_format($program->price, 0, ',', ' ') }}</span>
                                <span class="ds-price-currency">DA</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                @auth
                                    @php
                                        $isFavorited = Auth::user()->hasFavorited($program);
                                    @endphp
                                    <button type="button" onclick="toggleFavorite(event, '{{ $program->slug }}', this)" class="ds-btn ds-btn-ghost ds-btn-sm" style="padding: 0.4rem; color: {{ $isFavorited ? 'var(--error)' : 'var(--taupe)' }};" title="{{ __('Ajouter aux favoris') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                    </button>
                                @endauth
                                <a href="{{ url('/programs/' . $program->slug) }}" class="ds-btn ds-btn-secondary ds-btn-sm">{{ __('Détails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $demoPrograms = [
                        ['title' => 'Sahara Doré', 'desc' => 'Circuit dans les dunes du Grand Erg Oriental avec nuits sous les étoiles.', 'price' => '45 000', 'duration' => '5 jours', 'img' => 'https://images.unsplash.com/photo-1509023464722-18d996393ca8?w=600&q=80'],
                        ['title' => 'Côte Turquoise', 'desc' => 'Découverte des plages secrètes de la côte algéroise et jijélienne.', 'price' => '25 000', 'duration' => '3 jours', 'img' => 'https://images.unsplash.com/photo-1504512485720-7d83a16ee930?w=600&q=80'],
                        ['title' => 'Héritage Ottoman', 'desc' => 'Voyage culturel à travers les palais et mosquées d\'Alger et Constantine.', 'price' => '35 000', 'duration' => '4 jours', 'img' => 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?w=600&q=80'],
                    ];
                @endphp
                @foreach($demoPrograms as $demo)
                    <div class="ds-card">
                        <img src="{{ $demo['img'] }}" alt="{{ $demo['title'] }}" class="ds-card-img" loading="lazy">
                        <div class="ds-card-body">
                            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                                <span class="ds-badge ds-badge-taupe">{{ $demo['duration'] }}</span>
                                <span class="ds-badge ds-badge-gold">{{ __('Populaire') }}</span>
                            </div>
                            <h3 class="ds-card-title">{{ $demo['title'] }}</h3>
                            <p class="ds-card-text" style="margin-bottom:1rem;">{{ $demo['desc'] }}</p>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <span class="ds-price">{{ $demo['price'] }}</span>
                                    <span class="ds-price-currency">DA</span>
                                </div>
                                <a href="#" class="ds-btn ds-btn-secondary ds-btn-sm">{{ __('Détails') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

        <div style="text-align:center; margin-top:3rem;">
            <a href="{{ url('/programs') }}" class="ds-btn ds-btn-primary">
                {{ __('Voir tous les programmes') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="ds-section">
    <div class="ds-container-narrow">
        <div class="ds-section-header">
            <h2 class="ds-section-title">{{ __('Ce que disent nos voyageurs') }}</h2>
            <div class="ds-section-divider"></div>
        </div>

        <div class="ds-grid-2" style="gap:3rem;">
            <div class="ds-testimonial ds-animate-in">
                <div class="ds-testimonial-quote" style="padding-top:2rem;">
                    {{ __('Une expérience extraordinaire ! Notre guide connaissait chaque recoin du Sahara. Les couchers de soleil sur les dunes resteront gravés dans ma mémoire.') }}
                </div>
                <div class="ds-testimonial-name">Marie Laurent</div>
                <div class="ds-testimonial-role">{{ __('Voyageuse — Paris') }}</div>
            </div>

            <div class="ds-testimonial ds-animate-in ds-animate-delay-2">
                <div class="ds-testimonial-quote" style="padding-top:2rem;">
                    {{ __('Dawn & Sea m\'a fait découvrir un autre visage de l\'Algérie. Professionnalisme, authenticité, et des paysages à couper le souffle. Je recommande à 100%.') }}
                </div>
                <div class="ds-testimonial-name">Ahmed Benali</div>
                <div class="ds-testimonial-role">{{ __('Voyageur — Dubaï') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, var(--charcoal) 0%, #3a3a3a 100%); padding: 5rem 0; text-align: center;">
    <div class="ds-container-narrow">
        <h2 style="font-family:var(--font-serif); font-size:2.5rem; color:var(--white); margin-bottom:1rem;">
            {{ __('Prêt à vivre l\'aventure ?') }}
        </h2>
        <p style="color:rgba(255,255,255,0.6); font-size:1.1rem; margin-bottom:2.5rem; max-width:500px; margin-left:auto; margin-right:auto;">
            {{ __('Rejoignez des centaines de voyageurs qui ont choisi Dawn & Sea pour découvrir l\'Algérie autrement.') }}
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="ds-btn ds-btn-primary ds-btn-lg">{{ __('Commencer l\'aventure') }}</a>
            <a href="#contact" class="ds-btn ds-btn-secondary ds-btn-lg" style="border-color:var(--gold); color:var(--gold);">{{ __('Nous contacter') }}</a>
        </div>
    </div>
</section>
@endsection
