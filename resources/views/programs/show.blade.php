@extends('layouts.app')

@section('title', $program->title . ' — Dawn & Sea')

@section('content')
@php
    $imgUrl = $program->image ? asset($program->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80';
    $avgRating = $program->average_rating;
    $reviewsCount = $program->reviews_count;
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
                @if($reviewsCount > 0)
                    <span style="display: flex; align-items: center; gap: 0.4rem; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border-radius: 999px; padding: 0.3rem 0.9rem; font-size: 0.85rem;">
                        <span style="color: #f59e0b;">★</span>
                        <span>{{ number_format($avgRating, 1) }}</span>
                        <span style="opacity: 0.7;">({{ $reviewsCount }} avis)</span>
                    </span>
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

        <!-- Flash messages -->
        @if(session('success'))
            <div style="background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 1rem 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <span style="font-size: 1.2rem;">✅</span>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 1rem 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                <strong>Veuillez corriger les erreurs :</strong>
                <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                    <div class="ds-card-static" style="background: var(--white); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); box-shadow: var(--shadow-sm); margin-bottom: 2.5rem;">
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

                <!-- ===== REVIEWS SECTION ===== -->
                <div id="reviews" class="ds-card-static" style="background: var(--white); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); box-shadow: var(--shadow-sm);">

                    <!-- Section header with average -->
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
                        <h2 style="font-family: var(--font-serif); font-size: 1.85rem; color: var(--charcoal); margin: 0;">
                            {{ __('Avis & Notes') }}
                        </h2>
                        @if($reviewsCount > 0)
                            <div style="display: flex; align-items: center; gap: 1rem; background: var(--cream-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md);">
                                <span style="font-size: 2.5rem; font-weight: 700; color: var(--charcoal); line-height: 1;">{{ number_format($avgRating, 1) }}</span>
                                <div>
                                    <div style="display: flex; gap: 3px; margin-bottom: 0.2rem;">
                                        @for($s = 1; $s <= 5; $s++)
                                            @if($s <= round($avgRating))
                                                <span style="color: #f59e0b; font-size: 1.25rem;">★</span>
                                            @else
                                                <span style="color: #d1d5db; font-size: 1.25rem;">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span style="font-size: 0.8rem; color: var(--taupe);">{{ $reviewsCount }} {{ $reviewsCount > 1 ? 'avis' : 'avis' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Review Form -->
                    @auth
                        <div style="background: var(--cream-dark); border-radius: var(--radius-md); padding: 2rem; margin-bottom: 2.5rem; border: 1px solid rgba(168,155,138,0.15);">
                            <h3 style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--charcoal); margin: 0 0 1.25rem 0;">
                                {{ $userReview ? '✏️ Modifier votre avis' : '💬 Laisser un avis' }}
                            </h3>

                            <form action="{{ route('programs.reviews.store', $program) }}" method="POST">
                                @csrf

                                <!-- Star Rating Picker -->
                                <div style="margin-bottom: 1.25rem;">
                                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--taupe); display: block; margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Votre note
                                    </label>
                                    <div class="star-picker" style="display: flex; gap: 6px;" id="starPicker">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                class="star-btn"
                                                data-value="{{ $i }}"
                                                style="background: none; border: none; cursor: pointer; font-size: 2rem; line-height: 1; color: {{ ($userReview && $userReview->rating >= $i) ? '#f59e0b' : '#d1d5db' }}; transition: color 0.15s, transform 0.15s; padding: 0 2px;"
                                                title="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}">★</button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', $userReview?->rating ?? '') }}" required>
                                    <p style="font-size: 0.78rem; color: var(--taupe); margin-top: 0.35rem;" id="ratingLabel">
                                        {{ $userReview ? $userReview->rating . ' étoile' . ($userReview->rating > 1 ? 's' : '') : 'Cliquez pour noter' }}
                                    </p>
                                </div>

                                <!-- Comment -->
                                <div style="margin-bottom: 1.25rem;">
                                    <label for="reviewComment" style="font-size: 0.85rem; font-weight: 600; color: var(--taupe); display: block; margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Votre commentaire
                                    </label>
                                    <textarea
                                        id="reviewComment"
                                        name="comment"
                                        rows="4"
                                        placeholder="Partagez votre expérience en détail (min. 10 caractères)..."
                                        style="width: 100%; padding: 0.85rem 1rem; border: 1px solid rgba(168,155,138,0.3); border-radius: var(--radius-sm); font-family: var(--font-sans); font-size: 0.95rem; color: var(--charcoal); background: var(--white); resize: vertical; box-sizing: border-box; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='rgba(168,155,138,0.3)'"
                                    >{{ old('comment', $userReview?->comment ?? '') }}</textarea>
                                    <p style="font-size: 0.78rem; color: var(--taupe); margin-top: 0.35rem;" id="charCount">0 / 1000 caractères</p>
                                </div>

                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <button type="submit" class="ds-btn ds-btn-primary" style="padding: 0.75rem 2rem;">
                                        {{ $userReview ? '💾 Mettre à jour' : '📤 Publier mon avis' }}
                                    </button>
                                    @if($userReview)
                                        <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Supprimer votre avis ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ds-btn ds-btn-secondary" style="padding: 0.75rem 1.5rem; color: var(--error);">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </form>
                        </div>
                    @else
                        <div style="background: var(--cream-dark); border-radius: var(--radius-md); padding: 1.5rem 2rem; margin-bottom: 2.5rem; border: 1px solid rgba(168,155,138,0.15); text-align: center;">
                            <p style="color: var(--taupe); margin: 0; font-size: 0.95rem;">
                                💡 <a href="{{ route('login') }}" style="color: var(--gold); text-decoration: underline; font-weight: 600;">Connectez-vous</a> pour laisser un avis et noter ce programme.
                            </p>
                        </div>
                    @endauth

                    <!-- Reviews List -->
                    @if($program->reviews->isEmpty())
                        <div style="text-align: center; padding: 2.5rem 0; color: var(--taupe);">
                            <div style="font-size: 3rem; margin-bottom: 0.75rem;">⭐</div>
                            <p style="font-size: 1rem; margin: 0;">Aucun avis pour le moment. Soyez le premier à partager votre expérience !</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            @foreach($program->reviews as $review)
                                <div style="padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid rgba(168,155,138,0.12); background: {{ Auth::id() === $review->user_id ? 'rgba(197,165,90,0.06)' : 'var(--cream-dark)' }}; position: relative;">
                                    
                                    @if(Auth::id() === $review->user_id)
                                        <span style="position: absolute; top: 1rem; right: 1rem; font-size: 0.72rem; background: var(--gold); color: var(--white); padding: 0.2rem 0.6rem; border-radius: 999px; font-weight: 600;">Votre avis</span>
                                    @endif

                                    <!-- Reviewer header -->
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.85rem;">
                                        @if($review->user?->avatar)
                                            <img src="{{ asset($review->user->avatar) }}" alt="{{ $review->user->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(197,165,90,0.4); flex-shrink: 0;">
                                        @else
                                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), #b8860b); display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 700; font-size: 1rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($review->user?->name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: var(--charcoal); font-size: 0.95rem;">
                                                {{ $review->user?->name ?? 'Utilisateur' }}
                                            </div>
                                            <div style="font-size: 0.78rem; color: var(--taupe);">
                                                {{ $review->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <!-- Star display -->
                                        <div style="margin-left: auto; display: flex; gap: 2px;">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span style="color: {{ $s <= $review->rating ? '#f59e0b' : '#d1d5db' }}; font-size: 1.1rem;">★</span>
                                            @endfor
                                        </div>
                                    </div>

                                    <!-- Comment text -->
                                    <p style="font-size: 0.95rem; color: var(--charcoal-soft); line-height: 1.7; margin: 0;">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
                <!-- ===== END REVIEWS ===== -->

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
                        
                        @auth
                            @php
                                $isFavorited = Auth::user()->hasFavorited($program);
                            @endphp
                            <button type="button" onclick="toggleFavorite(event, '{{ $program->slug }}', this)" class="ds-btn ds-btn-secondary" style="width: 100%; padding: 0.85rem; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: {{ $isFavorited ? 'var(--error)' : 'var(--taupe)' }};">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                {{ __('Ajouter aux favoris') }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="ds-btn ds-btn-secondary" style="width: 100%; padding: 0.85rem; font-size: 0.9rem; text-align: center; display: block;">
                                ❤️ {{ __('Connectez-vous pour ajouter aux favoris') }}
                            </a>
                        @endauth

                        @if($reviewsCount > 0)
                            <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid rgba(168,155,138,0.12); text-align: center;">
                                <a href="#reviews" style="font-size: 0.85rem; color: var(--gold); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                                    <span>★</span>
                                    {{ number_format($avgRating, 1) }} — Voir les {{ $reviewsCount }} avis
                                </a>
                            </div>
                        @endif
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

<!-- Star Picker JavaScript -->
<script>
(function () {
    const picker  = document.getElementById('starPicker');
    const input   = document.getElementById('ratingInput');
    const label   = document.getElementById('ratingLabel');
    const textarea = document.getElementById('reviewComment');
    const charCount = document.getElementById('charCount');

    if (!picker) return;

    const stars = Array.from(picker.querySelectorAll('.star-btn'));
    const labels = ['', '1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles'];

    function paint(value, isHover = false) {
        stars.forEach((s, i) => {
            s.style.color = (i + 1) <= value ? '#f59e0b' : '#d1d5db';
            s.style.transform = (i + 1) <= value && isHover ? 'scale(1.15)' : 'scale(1)';
        });
    }

    // Initial state
    const initial = parseInt(input.value) || 0;
    if (initial) paint(initial);

    stars.forEach((star, idx) => {
        const val = idx + 1;

        star.addEventListener('mouseenter', () => paint(val, true));
        star.addEventListener('mouseleave', () => paint(parseInt(input.value) || 0));
        star.addEventListener('click', () => {
            input.value = val;
            paint(val);
            label.textContent = labels[val];
        });
    });

    // Character counter
    if (textarea && charCount) {
        function updateCount() {
            charCount.textContent = textarea.value.length + ' / 1000 caractères';
            charCount.style.color = textarea.value.length > 900 ? 'var(--error)' : 'var(--taupe)';
        }
        textarea.addEventListener('input', updateCount);
        updateCount();
    }
})();
</script>
@endsection
