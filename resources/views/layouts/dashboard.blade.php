@extends('layouts.app')

@section('title', 'Dashboard Guide')
@section('hide_footer', 'true')

@section('content')
<div style="padding-top: 72px; display: flex; min-height: 100vh;">
    <!-- Sidebar -->
    <aside class="ds-sidebar" id="dashboard-sidebar">
        <div class="ds-sidebar-user">
            <div class="ds-sidebar-avatar-placeholder">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="ds-sidebar-name">{{ Auth::user()->name }}</div>
            <span class="ds-badge ds-badge-gold">{{ __('Guide') }}</span>
        </div>

        <ul class="ds-sidebar-nav">
            <li>
                <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    {{ __('Tableau de Bord') }}
                </a>
            </li>
            <li>
                <a href="{{ url('/dashboard/programs') }}" class="{{ request()->is('dashboard/programs*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    {{ __('Mes Programmes') }}
                </a>
            </li>
            <li>
                <a href="{{ url('/dashboard/stats') }}" class="{{ request()->is('dashboard/stats*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    {{ __('Statistiques') }}
                </a>
            </li>
            <li>
                <a href="{{ url('/profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ __('Mon Profil') }}
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: var(--error);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        {{ __('Déconnexion') }}
                    </a>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="ds-main-with-sidebar" style="background: var(--cream-dark);">
        @yield('dashboard_content')
    </div>
</div>
@endsection
