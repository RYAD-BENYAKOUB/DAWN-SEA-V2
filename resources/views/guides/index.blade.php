@extends('layouts.app')

@section('title', __('Nos Guides Touristiques') . ' — Dawn & Sea')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(rgba(44, 44, 44, 0.4), rgba(44, 44, 44, 0.6)), url('https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover; padding: 120px 0 80px; text-align: center; color: var(--white);">
    <div class="ds-container">
        <h1 style="color: var(--white); font-size: 3.5rem; font-family: var(--font-serif); margin-bottom: 1rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">
            {{ __('Nos Guides Experts') }}
        </h1>
        <p style="color: var(--cream-dark); max-width: 600px; margin: 0 auto; font-size: 1.15rem; text-shadow: 0 1px 4px rgba(0,0,0,0.3);">
            {{ __('Découvrez les profils de nos guides locaux certifiés, passionnés par leur région et prêts à vous faire vivre une expérience inoubliable.') }}
        </p>
    </div>
</div>

<div class="ds-container" style="padding: 4rem 0;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem;">
        @foreach($guides as $guide)
            <div class="ds-card ds-animate-in">
                <div style="padding: 2rem; text-align: center;">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem auto; border: 4px solid var(--cream);">
                        <img src="{{ $guide->avatar ? asset($guide->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($guide->user->name) . '&background=C5A880&color=fff' }}" alt="{{ $guide->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <h3 class="ds-card-title" style="margin-bottom: 0.5rem;">{{ $guide->user->name }}</h3>
                    <div style="color: var(--gold); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                        {{ $guide->speciality }}
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: var(--charcoal-soft); font-size: 0.95rem; margin-bottom: 1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        {{ $guide->location }}
                    </div>

                    <p style="color: var(--charcoal-soft); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; text-align: left;">
                        {{ Str::limit($guide->bio, 150) }}
                    </p>

                    <div style="border-top: 1px solid var(--cream-dark); padding-top: 1.5rem; text-align: left;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: var(--charcoal-soft); font-size: 0.95rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <a href="mailto:{{ $guide->user->email }}" style="color: inherit; text-decoration: none;">{{ $guide->user->email }}</a>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--charcoal-soft); font-size: 0.95rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <a href="tel:{{ $guide->phone }}" style="color: inherit; text-decoration: none;">{{ $guide->phone }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
