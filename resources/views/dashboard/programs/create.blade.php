@extends('layouts.dashboard')

@section('title', __('Créer un Programme') . ' — Dawn & Sea')

@section('dashboard_content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
        <a href="{{ url('/dashboard') }}" class="ds-btn ds-btn-ghost ds-btn-sm" style="padding: 0.5rem 1rem;">
            ← {{ __('Retour') }}
        </a>
        <h2 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--charcoal); margin: 0;">
            {{ __('Créer un Nouveau Programme') }}
        </h2>
    </div>

    <!-- Form Card -->
    <div class="ds-card-static" style="background: var(--white); padding: 3rem 2.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md); border: 1px solid rgba(168,155,138,0.12);">
        <form method="POST" action="{{ route('dashboard.programs.store') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf

            <!-- Title -->
            <div class="ds-input-group">
                <x-input-label for="title" :value="__('Titre du programme')" />
                <x-text-input id="title" name="title" type="text" style="margin-top: 0.25rem;" :value="old('title')" required autofocus placeholder="{{ __('Ex: Sahara Doré, Côte Turquoise...') }}" />
                <x-input-error :messages="$errors->get('title')" style="margin-top: 0.5rem;" />
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Location -->
                <div class="ds-input-group">
                    <x-input-label for="location" :value="__('Lieu / Destination')" />
                    <x-text-input id="location" name="location" type="text" style="margin-top: 0.25rem;" :value="old('location')" required placeholder="{{ __('Ex: Djanet, Jijel, Alger...') }}" />
                    <x-input-error :messages="$errors->get('location')" style="margin-top: 0.5rem;" />
                </div>

                <!-- Duration -->
                <div class="ds-input-group">
                    <x-input-label for="duration" :value="__('Durée')" />
                    <x-text-input id="duration" name="duration" type="text" style="margin-top: 0.25rem;" :value="old('duration')" required placeholder="{{ __('Ex: 3 jours, 5 jours...') }}" />
                    <x-input-error :messages="$errors->get('duration')" style="margin-top: 0.5rem;" />
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Price -->
                <div class="ds-input-group">
                    <x-input-label for="price" :value="__('Prix (DA)')" />
                    <x-text-input id="price" name="price" type="number" min="0" style="margin-top: 0.25rem;" :value="old('price')" required placeholder="{{ __('Ex: 35000') }}" />
                    <x-input-error :messages="$errors->get('price')" style="margin-top: 0.5rem;" />
                </div>

                <!-- Max Participants -->
                <div class="ds-input-group">
                    <x-input-label for="max_participants" :value="__('Nombre max de participants')" />
                    <x-text-input id="max_participants" name="max_participants" type="number" min="1" style="margin-top: 0.25rem;" :value="old('max_participants')" required placeholder="{{ __('Ex: 12') }}" />
                    <x-input-error :messages="$errors->get('max_participants')" style="margin-top: 0.5rem;" />
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Difficulty -->
                <div class="ds-input-group">
                    <x-input-label for="difficulty" :value="__('Niveau de difficulté')" />
                    <select id="difficulty" name="difficulty" class="ds-input ds-select" style="margin-top: 0.25rem;" required>
                        <option value="facile" {{ old('difficulty') === 'facile' ? 'selected' : '' }}>{{ __('Facile') }}</option>
                        <option value="modéré" {{ old('difficulty') === 'modéré' ? 'selected' : '' }}>{{ __('Modéré') }}</option>
                        <option value="difficile" {{ old('difficulty') === 'difficile' ? 'selected' : '' }}>{{ __('Difficile') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('difficulty')" style="margin-top: 0.5rem;" />
                </div>

                <!-- Image URL (optional) -->
                <div class="ds-input-group">
                    <x-input-label for="image_url" :value="__('URL de l\'image (optionnel)')" />
                    <x-text-input id="image_url" name="image_url" type="url" style="margin-top: 0.25rem;" :value="old('image_url')" placeholder="https://images.unsplash.com/..." />
                    <x-input-error :messages="$errors->get('image_url')" style="margin-top: 0.5rem;" />
                </div>
            </div>

            <!-- Description -->
            <div class="ds-input-group">
                <x-input-label for="description" :value="__('Description détaillée')" />
                <textarea id="description" name="description" class="ds-input" style="margin-top: 0.25rem; min-height: 180px; resize: vertical;" required placeholder="{{ __('Décrivez l\'itinéraire, les activités comprises, le transport, l\'hébergement...') }}">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" style="margin-top: 0.5rem;" />
            </div>

            <!-- Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ url('/dashboard') }}" class="ds-btn ds-btn-secondary" style="padding: 0.85rem 2rem;">
                    {{ __('Annuler') }}
                </a>
                <x-primary-button style="padding: 0.85rem 2.5rem;">
                    {{ __('Créer le programme') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
