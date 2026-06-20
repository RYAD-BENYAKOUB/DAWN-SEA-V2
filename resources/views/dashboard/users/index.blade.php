@extends('layouts.app')

@section('title', __('Gestion des Utilisateurs') . ' — Dawn & Sea')

@section('content')
<div class="ds-container" style="padding: 4rem 0;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ __('Gestion des Utilisateurs') }}</h1>
            <p style="color: var(--charcoal-soft);">{{ __('Promouvoir des utilisateurs au rang d\'administrateur.') }}</p>
        </div>
        <a href="{{ route('dashboard.superadmin') }}" class="ds-btn ds-btn-secondary">
            {{ __('Retour au Tableau de bord') }}
        </a>
    </div>

    @if(session('success'))
        <div style="background: var(--success-light); color: var(--success); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: var(--error-light); color: var(--error); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="ds-card ds-card-body">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--cream-dark); text-align: left;">
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Utilisateur') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Email') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Rôle actuel') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid var(--cream-dark);">
                    <td style="padding: 1rem 0.5rem;">
                        <div style="font-weight: 500;">{{ $user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--charcoal-soft);">{{ $user->phone ?? 'Aucun téléphone' }}</div>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: var(--charcoal-soft);">{{ $user->email }}</td>
                    <td style="padding: 1rem 0.5rem;">
                        <span class="ds-badge {{ $user->role === 'superadmin' ? 'ds-badge-gold' : ($user->role === 'admin' ? 'ds-badge-success' : '') }}" style="background: var(--cream-dark); color: var(--charcoal);">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        @if(in_array($user->role, ['user', 'admin']))
                            <form action="{{ route('dashboard.users.updateRole', $user) }}" method="POST" style="display: flex; gap: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="ds-input" style="padding: 0.25rem 0.5rem; font-size: 0.85rem; min-width: 120px;">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="ds-btn ds-btn-primary ds-btn-sm" style="padding: 0.25rem 0.75rem;">
                                    {{ __('Mettre à jour') }}
                                </button>
                            </form>
                        @else
                            <span style="color: var(--taupe); font-size: 0.85rem;">{{ __('Non modifiable') }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 2rem;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
