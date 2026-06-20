@extends('layouts.app')

@section('title', __('Nos Destinations') . ' — Dawn & Sea')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(rgba(44, 44, 44, 0.4), rgba(44, 44, 44, 0.6)), url('https://images.unsplash.com/photo-1549487050-7164da2504ae?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover; padding: 120px 0 80px; text-align: center; color: var(--white);">
    <div class="ds-container">
        <h1 style="color: var(--white); font-size: 3.5rem; font-family: var(--font-serif); margin-bottom: 1rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
            {{ __('Destinations Uniques') }}
        </h1>
        <p style="color: var(--cream-dark); max-width: 600px; margin: 0 auto; font-size: 1.15rem; text-shadow: 0 1px 4px rgba(0,0,0,0.3);">
            {{ __('Explorez la richesse de nos régions. Des plages de la Méditerranée aux dunes dorées du Sahara, chaque wilaya vous réserve une aventure exceptionnelle.') }}
        </p>
    </div>
</div>

<div class="ds-container" style="padding: 4rem 0;">
    <div class="ds-grid">
        @foreach($destinations as $destination)
            <div class="ds-card ds-animate-in" style="overflow: hidden; border-radius: 8px;">
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <a href="{{ url('/programs?location=' . urlencode($destination['name'])) }}">
                        <img src="{{ $destination['image'] ? asset($destination['image']) : 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $destination['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="ds-badge" style="position: absolute; top: 1rem; left: 1rem; z-index: 10; background: var(--gold); color: white;">{{ $destination['count'] }} programme(s)</div>
                    </a>
                </div>
                <div class="ds-card-content" style="text-align: center;">
                    <h3 class="ds-card-title">
                        <a href="{{ url('/programs?location=' . urlencode($destination['name'])) }}" style="text-decoration: none; color: inherit;">
                            {{ $destination['name'] }}
                        </a>
                    </h3>
                    <p style="color: var(--charcoal-soft); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ $destination['description'] }}
                    </p>
                    <a href="{{ url('/programs?location=' . urlencode($destination['name'])) }}" class="ds-btn ds-btn-primary ds-btn-sm" style="width: 100%;">
                        {{ __('Explorer cette destination') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
