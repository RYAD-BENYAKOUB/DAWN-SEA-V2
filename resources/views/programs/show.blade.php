@extends('layouts.app')

@section('title', $program->title . ' — Dawn & Sea')

@section('content')
@php
    $imgUrl = $program->image ? asset($program->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80';
@endphp

<!-- Program Hero Banner -->
<div style="background: linear-gradient(rgba(44, 44, 44, 0.3), rgba(44, 44, 44, 0.7)), url('{{ $imgUrl }}') no-repeat center center/cover; min-height: 500px; padding: 160px 0 80px; display: flex; align-items: flex-end; color: var(--white);">
    <div class="ds-container" style="width: 100%;">
        <div style="max-width: 800px;">
            <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 1rem;">
                <span class="ds-badge ds-badge-gold" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                    {{ $program->location }}
                </span>
                @if($program->difficulty === 'facile')
                    <span class="ds-badge ds-badge-success" style="font-size: 0.85rem; padding: 0.4rem 1rem;">{{ __('Facile') }}</span>
                @elseif($program->difficulty === 'modéré')
                    <span class="ds-badge ds-badge-gold" style="background: rgba(197,165,90,0.25); color: var(--white); font-size: 0.85rem; padding: 0.4rem 1rem; border: 1px solid var(--gold);">{{ __('Modéré') }}</span>
                @else
                    <span class="ds-badge ds-badge-error" style="font-size: 0.85rem; padding: 0.4rem 1rem;">{{ __('Difficile') }}</span>
                @endif
            </div>
            <h1 style="color: var(--white); font-size: 4rem; font-family: var(--font-serif); margin-bottom: 1rem; line-height: 1.1; text-shadow: 0 3px 15px rgba(0,0,0,0.5);">
                {{ $program->title }}
            </h1>
            <p style="font-size: 1.25rem; color: var(--cream-dark); max-width: 600px; line-height: 1.6; text-shadow: 0 1px 4px rgba(0,0,0,0.4);">
                {{ __('Une expérience extraordinaire conçue et animée par un guide local professionnel.') }}
            </p>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div style="padding: 5rem 0; background: var(--cream);">
    <div class="ds-container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3.5rem; align-items: start;">
            
            <!-- Details Column -->
            <div>
                <!-- Description -->
                <div class="ds-card-static" style="background: var(--white); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); margin-bottom: 2.5rem; box-shadow: var(--shadow-sm);">
                    <h2 style="font-family: var(--font-serif); font-size: 1.85rem; margin-bottom: 1.5rem; color: var(--charcoal);">
                        {{ __('Description de l\'expérience') }}
                    </h2>
                    <div style="line-height: 1.8; color: var(--charcoal-soft); font-size: 1.05rem; white-space: pre-line;">
                        {{ $program->description }}
                    </div>
                </div>

                <!-- Guide Profile Card -->
                @if($program->guide)
                    <div class="ds-card-static" style="background: var(--white); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); box-shadow: var(--shadow-sm);">
                        <h2 style="font-family: var(--font-serif); font-size: 1.85rem; margin-bottom: 1.5rem; color: var(--charcoal);">
                            {{ __('Votre Guide Hôte') }}
                        </h2>
                        
                        <div style="display: flex; gap: 2rem; align-items: flex-start;">
                            @if($program->guide->avatar)
                                <img src="{{ asset($program->guide->avatar) }}" alt="{{ $program->guide->user->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); flex-shrink: 0;">
                            @else
                                <div class="ds-sidebar-avatar-placeholder" style="width: 80px; height: 80px; font-size: 1.75rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($program->guide->user->name ?? 'G', 0, 1)) }}
                                </div>
                            @endif
                            
                            <div>
                                <h3 style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--charcoal); margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                    {{ $program->guide->user->name ?? 'Guide Local' }}
                                    @if($program->guide->is_verified)
                                        <span class="ds-badge ds-badge-success" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">✓ {{ __('Vérifié') }}</span>
                                    @endif
                                </h3>
                                
                                <span class="ds-badge ds-badge-taupe" style="font-size: 0.75rem; margin-bottom: 1rem; display: inline-block;">
                                    Spécialité : {{ $program->guide->speciality ?? 'Générale' }}
                                </span>
                                
                                <p style="font-size: 0.95rem; color: var(--charcoal-soft); line-height: 1.6; margin: 0 0 1.5rem 0;">
                                    {!! preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank" style="color: var(--gold); text-decoration: underline;">$1</a>', e($program->guide->bio ?? 'Aucune biographie fournie.')) !!}
                                </p>

                                @auth
                                    <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--taupe);">
                                        <span>📞 {{ $program->guide->phone }}</span>
                                        <span>✉️ {{ $program->guide->user->email }}</span>
                                    </div>
                                @else
                                    <p style="font-size: 0.85rem; color: var(--taupe); font-style: italic; margin: 0;">
                                        💡 <a href="{{ route('login') }}" style="text-decoration: underline;">{{ __('Connectez-vous') }}</a> {{ __('pour voir les coordonnées du guide.') }}
                                    </p>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Booking / Specs Sidebar -->
            <div>
                <div class="ds-card-static" style="background: var(--white); border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); box-shadow: var(--shadow-lg); overflow: hidden; position: sticky; top: 100px;">
                    <!-- Price tag panel -->
                    <div style="background: var(--cream-dark); padding: 2rem; border-bottom: 1px solid rgba(168, 155, 138, 0.15); text-align: center;">
                        <span style="font-size: 0.85rem; color: var(--taupe); display: block; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                            {{ __('Prix tout compris') }}
                        </span>
                        <span class="ds-price" style="font-size: 2.25rem;">{{ number_format($program->price, 0, ',', ' ') }}</span> <span class="ds-price-currency" style="font-size: 1.25rem;">DA</span>
                    </div>

                    <!-- Specs details -->
                    <div style="padding: 2rem;">
                        <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2rem;">
                            
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="background: var(--cream-dark); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: var(--gold); flex-shrink: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div>
                                    <span style="font-size: 0.75rem; color: var(--taupe); display: block;">{{ __('Durée du séjour') }}</span>
                                    <span style="font-weight: 600; color: var(--charcoal); font-size: 0.95rem;">{{ $program->duration }}</span>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="background: var(--cream-dark); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: var(--gold); flex-shrink: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <span style="font-size: 0.75rem; color: var(--taupe); display: block;">{{ __('Lieu de rendez-vous') }}</span>
                                    <span style="font-weight: 600; color: var(--charcoal); font-size: 0.95rem;">{{ $program->location }}</span>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="background: var(--cream-dark); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: var(--gold); flex-shrink: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <div>
                                    <span style="font-size: 0.75rem; color: var(--taupe); display: block;">{{ __('Taille maximale du groupe') }}</span>
                                    <span style="font-weight: 600; color: var(--charcoal); font-size: 0.95rem;">{{ $program->max_participants }} {{ __('personnes') }}</span>
                                </div>
                            </div>

                        </div>

                        <!-- CTA Book -->
                        <button class="ds-btn ds-btn-primary" style="width: 100%; padding: 1rem; font-size: 0.95rem; margin-bottom: 1rem;" onclick="alert('Réservation simulée ! Pour réserver cette expérience de luxe, veuillez contacter directement le guide.')">
                            {{ __('Réserver cette Expérience') }}
                        </button>
                        
                        <button class="ds-btn ds-btn-secondary" style="width: 100%; padding: 0.85rem; font-size: 0.9rem;" onclick="alert('Ajouté à vos favoris (simulation).')">
                            ❤️ {{ __('Ajouter aux favoris') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Programs -->
        @if($relatedPrograms->isNotEmpty())
            <div style="margin-top: 6rem; border-top: 1px solid rgba(168, 155, 138, 0.15); padding-top: 4rem;">
                <h2 style="font-family: var(--font-serif); font-size: 2.25rem; text-align: center; margin-bottom: 3rem; color: var(--charcoal);">
                    {{ __('Expériences Similaires') }}
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem;">
                    @foreach($relatedPrograms as $rel)
                        @php
                            $relImgUrl = $rel->image ? asset($rel->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                        @endphp
                        <div class="ds-card">
                            <div style="position: relative;">
                                <img src="{{ $relImgUrl }}" alt="{{ $rel->title }}" class="ds-card-img" style="height: 200px; object-fit: cover;">
                                <div style="position: absolute; top: 1rem; left: 1rem; z-index: 10;">
                                    <span class="ds-badge ds-badge-gold" style="font-size: 0.7rem;">
                                        {{ $rel->location }}
                                    </span>
                                </div>
                            </div>
                            <div class="ds-card-body">
                                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--charcoal); margin-bottom: 0.5rem;">
                                    {{ $rel->title }}
                                </h3>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="ds-price" style="font-size: 1.15rem;">{{ number_format($rel->price, 0, ',', ' ') }} DA</span>
                                    <a href="{{ route('programs.show', $rel->slug) }}" class="ds-btn ds-btn-ghost ds-btn-sm" style="padding: 0.4rem 1rem;">
                                        {{ __('Découvrir') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
