@extends('layouts.app')

@section('title', __('Programmes Touristiques de Luxe') . ' — Dawn & Sea')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(rgba(44, 44, 44, 0.4), rgba(44, 44, 44, 0.6)), url('https://images.unsplash.com/photo-1539650116574-8efeb43e2750?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover; padding: 120px 0 80px; text-align: center; color: var(--white);">
    <div class="ds-container">
        <h1 style="color: var(--white); font-size: 3.5rem; font-family: var(--font-serif); margin-bottom: 1rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
            {{ __('Nos Programmes d\'Élite') }}
        </h1>
        <p style="color: var(--cream-dark); max-width: 600px; margin: 0 auto; font-size: 1.15rem; text-shadow: 0 1px 4px rgba(0,0,0,0.3);">
            {{ __('Explorez les paysages les plus magiques d\'Algérie à travers des séjours de luxe conçus et guidés par des experts certifiés.') }}
        </p>
    </div>
</div>

<!-- Search & Filters -->
<div style="background: var(--cream-dark); padding: 2.5rem 0; border-bottom: 1px solid rgba(168, 155, 138, 0.15);">
    <div class="ds-container">
        <form method="GET" action="{{ route('programs.index') }}" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1.5rem; align-items: end;">
            
            <div class="ds-input-group" style="margin-bottom: 0;">
                <label class="ds-label" for="search">{{ __('Rechercher') }}</label>
                <input type="text" id="search" name="search" class="ds-input" value="{{ request('search') }}" placeholder="{{ __('Ex: Sahara, Djanet, Alger...') }}">
            </div>

            <div class="ds-input-group" style="margin-bottom: 0;">
                <label class="ds-label" for="difficulty">{{ __('Difficulté') }}</label>
                <select id="difficulty" name="difficulty" class="ds-input ds-select">
                    <option value="">{{ __('Toutes') }}</option>
                    <option value="facile" {{ request('difficulty') === 'facile' ? 'selected' : '' }}>{{ __('Facile') }}</option>
                    <option value="modéré" {{ request('difficulty') === 'modéré' ? 'selected' : '' }}>{{ __('Modéré') }}</option>
                    <option value="difficile" {{ request('difficulty') === 'difficile' ? 'selected' : '' }}>{{ __('Difficile') }}</option>
                </select>
            </div>

            <div class="ds-input-group" style="margin-bottom: 0;">
                <label class="ds-label" for="price_max">{{ __('Prix maximum') }}</label>
                <select id="price_max" name="price_max" class="ds-input ds-select">
                    <option value="">{{ __('Tous les prix') }}</option>
                    <option value="30000" {{ request('price_max') === '30000' ? 'selected' : '' }}>{{ __('Sous 30 000 DA') }}</option>
                    <option value="50000" {{ request('price_max') === '50000' ? 'selected' : '' }}>{{ __('Sous 50 000 DA') }}</option>
                    <option value="100000" {{ request('price_max') === '100000' ? 'selected' : '' }}>{{ __('Sous 100 000 DA') }}</option>
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="ds-btn ds-btn-primary" style="padding: 0.75rem 2rem;">
                    {{ __('Filtrer') }}
                </button>
                @if(request()->anyFilled(['search', 'difficulty', 'price_max']))
                    <a href="{{ route('programs.index') }}" class="ds-btn ds-btn-secondary" style="padding: 0.75rem 1.25rem;">
                        ✕
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

<!-- Programs Grid -->
<div style="padding: 5rem 0; background: var(--cream);">
    <div class="ds-container">
        @if($programs->isEmpty())
            <div style="text-align: center; padding: 4rem 2rem; background: var(--white); border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--taupe)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <h3 style="font-family: var(--font-serif); margin-bottom: 0.5rem;">{{ __('Aucun programme trouvé') }}</h3>
                <p style="color: var(--taupe); max-width: 400px; margin: 0 auto;">{{ __('Essayez de modifier vos critères de recherche ou vos filtres pour obtenir plus de résultats.') }}</p>
                <a href="{{ route('programs.index') }}" class="ds-btn ds-btn-primary ds-btn-sm" style="margin-top: 1.5rem;">
                    {{ __('Réinitialiser les filtres') }}
                </a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem; margin-bottom: 3.5rem;">
                @foreach($programs as $program)
                    <div class="ds-card ds-animate-in">
                        @php
                            $imgUrl = $program->image ? asset($program->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                        @endphp
                        <div style="position: relative;">
                            <img src="{{ $imgUrl }}" alt="{{ $program->title }}" class="ds-card-img" style="object-fit: cover;">
                            <div class="ds-card-badge" style="position: absolute; top: 1rem; left: 1rem; z-index: 10;">
                                <span class="ds-badge ds-badge-gold" style="font-size: 0.75rem;">
                                    {{ $program->location }}
                                </span>
                            </div>
                        </div>

                        <div class="ds-card-body" style="display: flex; flex-direction: column; height: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.8rem; color: var(--taupe); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em;">
                                    {{ $program->duration }}
                                </span>
                                @if($program->difficulty === 'facile')
                                    <span class="ds-badge ds-badge-success" style="font-size: 0.7rem;">{{ __('Facile') }}</span>
                                @elseif($program->difficulty === 'modéré')
                                    <span class="ds-badge ds-badge-gold" style="background: rgba(197,165,90,0.1); font-size: 0.7rem;">{{ __('Modéré') }}</span>
                                @else
                                    <span class="ds-badge ds-badge-error" style="font-size: 0.7rem;">{{ __('Difficile') }}</span>
                                @endif
                            </div>

                            <h3 style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--charcoal); margin-bottom: 0.75rem;">
                                {{ $program->title }}
                            </h3>

                            <p style="font-size: 0.9rem; color: var(--charcoal-soft); line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                                {{ Str::limit($program->description, 130) }}
                            </p>

                            <hr style="border: 0; border-top: 1px solid rgba(168, 155, 138, 0.1); margin: 0 0 1.25rem 0;">

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-size: 0.75rem; color: var(--taupe); display: block;">{{ __('À partir de') }}</span>
                                    <span class="ds-price">{{ number_format($program->price, 0, ',', ' ') }}</span> <span class="ds-price-currency">DA</span>
                                </div>
                                <a href="{{ route('programs.show', $program->slug) }}" class="ds-btn ds-btn-primary ds-btn-sm" style="padding: 0.6rem 1.25rem;">
                                    {{ __('Découvrir') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center;">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
