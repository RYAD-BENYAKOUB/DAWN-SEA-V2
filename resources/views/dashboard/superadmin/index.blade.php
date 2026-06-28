@extends('layouts.app')

@section('title', __('Administration') . ' — Dawn & Sea')

@push('styles')
<style>
    /* ─── Admin Dashboard — Dawn & Sea Theme ─── */
    .admin-shell {
        min-height: 100vh;
        background: var(--charcoal);
        color: var(--cream);
        padding: 0;
    }

    /* ─── Top Header Bar ─── */
    .admin-topbar {
        background: rgba(44, 44, 44, 0.95);
        border-bottom: 1px solid rgba(197, 165, 90, 0.15);
        backdrop-filter: blur(12px);
        padding: 1.25rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 72px;
        z-index: 10;
    }

    .admin-topbar-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .admin-topbar-title .admin-badge {
        background: var(--gold);
        color: var(--charcoal);
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
    }

    .admin-topbar-title h1 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--cream);
        margin: 0;
        font-family: var(--font-serif);
    }

    .admin-topbar-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .admin-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
        font-family: var(--font-sans);
    }

    .admin-btn-ghost {
        background: rgba(197, 165, 90, 0.1);
        color: var(--taupe-light);
        border: 1px solid rgba(197, 165, 90, 0.2);
    }

    .admin-btn-ghost:hover {
        background: rgba(197, 165, 90, 0.2);
        color: var(--gold-light);
    }

    .admin-btn-primary {
        background: var(--gold);
        color: var(--charcoal);
        font-weight: 600;
    }

    .admin-btn-primary:hover {
        background: var(--gold-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-gold);
    }

    /* ─── Main Content ─── */
    .admin-content {
        padding: 2.5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ─── Stats Grid ─── */
    .admin-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .admin-stat-card {
        background: rgba(255, 248, 240, 0.04);
        border: 1px solid rgba(197, 165, 90, 0.12);
        border-radius: 16px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }

    .admin-stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: var(--card-accent, var(--gold));
        border-radius: 16px 16px 0 0;
    }

    .admin-stat-card:hover {
        transform: translateY(-3px);
        border-color: rgba(197, 165, 90, 0.3);
    }

    .admin-stat-card.accent-gold { --card-accent: var(--gold); }
    .admin-stat-card.accent-taupe { --card-accent: var(--taupe); }
    .admin-stat-card.accent-success { --card-accent: var(--success); }
    .admin-stat-card.accent-charcoal { --card-accent: var(--gold-dark); }

    .admin-stat-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        font-size: 1.3rem;
    }

    .admin-stat-card.accent-gold .admin-stat-icon-wrap { background: rgba(197, 165, 90, 0.15); }
    .admin-stat-card.accent-taupe .admin-stat-icon-wrap { background: rgba(139, 125, 107, 0.2); }
    .admin-stat-card.accent-success .admin-stat-icon-wrap { background: rgba(107, 142, 107, 0.2); }
    .admin-stat-card.accent-charcoal .admin-stat-icon-wrap { background: rgba(168, 137, 61, 0.15); }

    .admin-stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--cream);
        line-height: 1;
        margin-bottom: 0.5rem;
        font-variant-numeric: tabular-nums;
        font-family: var(--font-serif);
    }

    .admin-stat-label {
        font-size: 0.8rem;
        color: var(--taupe-light);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 500;
    }

    /* ─── Charts Row ─── */
    .admin-charts-grid {
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .admin-card {
        background: rgba(255, 248, 240, 0.04);
        border: 1px solid rgba(197, 165, 90, 0.12);
        border-radius: 16px;
        padding: 1.75rem;
    }

    .admin-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--taupe-light);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-card-title span {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--gold);
        display: inline-block;
    }

    /* ─── Users Table ─── */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table thead tr {
        border-bottom: 1px solid rgba(197, 165, 90, 0.12);
    }

    .admin-table th {
        padding: 0.75rem 1rem;
        color: var(--taupe);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        text-align: left;
    }

    .admin-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(197, 165, 90, 0.06);
        font-size: 0.875rem;
        color: var(--cream-dark);
    }

    .admin-table tbody tr:hover {
        background: rgba(197, 165, 90, 0.05);
    }

    .admin-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--charcoal);
        flex-shrink: 0;
    }

    .admin-user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .admin-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .badge-superadmin { background: var(--charcoal); color: var(--gold); border: 1px solid rgba(197, 165, 90, 0.3); }
    .badge-admin { background: rgba(139, 125, 107, 0.2); color: var(--taupe-light); border: 1px solid rgba(139, 125, 107, 0.3); }
    .badge-guide { background: rgba(107, 142, 107, 0.2); color: var(--success); border: 1px solid rgba(107, 142, 107, 0.3); }
    .badge-user { background: rgba(197, 165, 90, 0.1); color: var(--gold-light); border: 1px solid rgba(197, 165, 90, 0.15); }

    /* ─── Quick Actions ─── */
    .admin-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .admin-action-card {
        background: rgba(255, 248, 240, 0.04);
        border: 1px solid rgba(197, 165, 90, 0.1);
        border-radius: 12px;
        padding: 1.25rem 1rem;
        text-align: center;
        text-decoration: none;
        color: var(--taupe-light);
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .admin-action-card:hover {
        background: rgba(197, 165, 90, 0.1);
        border-color: rgba(197, 165, 90, 0.3);
        color: var(--gold);
        transform: translateY(-2px);
    }

    .admin-action-card .action-icon {
        font-size: 1.5rem;
    }

    @media (max-width: 900px) {
        .admin-charts-grid { grid-template-columns: 1fr; }
        .admin-topbar { padding: 1rem 1.25rem; }
        .admin-content { padding: 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="admin-shell">

    {{-- Top Header --}}
    <div class="admin-topbar">
        <div class="admin-topbar-title">
            <span class="admin-badge">⬡ SuperAdmin</span>
            <h1>Espace Administration</h1>
        </div>
        <div class="admin-topbar-actions">
            <a href="{{ route('home') }}" class="admin-btn admin-btn-ghost">
                ← Site public
            </a>
            <a href="{{ route('dashboard.users.index') }}" class="admin-btn admin-btn-primary">
                👥 Gérer les utilisateurs
            </a>
        </div>
    </div>

    <div class="admin-content">

        {{-- Welcome Line --}}
        <div style="margin-bottom: 2rem;">
            <p style="color: var(--taupe); font-size: 0.875rem;">
                Connecté en tant que <strong style="color: var(--gold);">{{ Auth::user()->name }}</strong> ·
                {{ now()->format('l d F Y') }}
            </p>
        </div>

        {{-- KPI Stats --}}
        <div class="admin-stats-grid">
            <div class="admin-stat-card accent-gold">
                <div class="admin-stat-icon-wrap">👥</div>
                <div class="admin-stat-value">{{ $totalUsers }}</div>
                <div class="admin-stat-label">Utilisateurs inscrits</div>
            </div>
            <div class="admin-stat-card accent-taupe">
                <div class="admin-stat-icon-wrap">🗺️</div>
                <div class="admin-stat-value">{{ $totalGuides }}</div>
                <div class="admin-stat-label">Guides actifs</div>
            </div>
            <div class="admin-stat-card accent-success">
                <div class="admin-stat-icon-wrap">📅</div>
                <div class="admin-stat-value">{{ $totalPrograms }}</div>
                <div class="admin-stat-label">Programmes</div>
            </div>
            <div class="admin-stat-card accent-charcoal">
                <div class="admin-stat-icon-wrap">🛡️</div>
                <div class="admin-stat-value">{{ $totalAdmins }}</div>
                <div class="admin-stat-label">Administrateurs</div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="admin-card" style="margin-bottom: 2rem;">
            <div class="admin-card-title"><span></span>Actions rapides</div>
            <div class="admin-actions-grid">
                <a href="{{ route('dashboard.users.index') }}" class="admin-action-card">
                    <span class="action-icon">👥</span>
                    Utilisateurs
                </a>
                <a href="{{ route('programs.index') }}" class="admin-action-card">
                    <span class="action-icon">📋</span>
                    Programmes
                </a>
                <a href="{{ route('guides.index') }}" class="admin-action-card">
                    <span class="action-icon">🗺️</span>
                    Guides
                </a>
                <a href="{{ route('destinations.index') }}" class="admin-action-card">
                    <span class="action-icon">📍</span>
                    Destinations
                </a>
                <a href="{{ route('profile.edit') }}" class="admin-action-card">
                    <span class="action-icon">⚙️</span>
                    Mon profil
                </a>
            </div>
        </div>

        {{-- Charts --}}
        <div class="admin-charts-grid">
            <div class="admin-card">
                <div class="admin-card-title"><span></span>Répartition des rôles</div>
                <div id="role_pie_chart" style="width: 100%; height: 300px;"></div>
            </div>
            <div class="admin-card">
                <div class="admin-card-title"><span style="background: var(--success);"></span>Programmes par destination</div>
                <div id="location_bar_chart" style="width: 100%; height: 300px;"></div>
            </div>
        </div>

        {{-- Recent Users Table --}}
        <div class="admin-card">
            <div class="admin-card-title"><span style="background: var(--gold-dark);"></span>Inscriptions récentes</div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Inscrit le</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td>
                            <div class="admin-user-cell">
                                <div class="admin-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="color: var(--taupe);">{{ $user->email }}</td>
                        <td>
                            @php
                                $badgeClass = match($user->role) {
                                    'superadmin' => 'badge-superadmin',
                                    'admin' => 'badge-admin',
                                    'guide' => 'badge-guide',
                                    default => 'badge-user',
                                };
                            @endphp
                            <span class="admin-role-badge {{ $badgeClass }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td style="color: var(--taupe);">{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Google Charts --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Role Pie Chart
        var roleData = google.visualization.arrayToDataTable(@json($roleData));
        var roleOptions = {
            backgroundColor: 'transparent',
            pieHole: 0.5,
            colors: ['#C5A55A', '#6B8E6B', '#8B7D6B'],
            chartArea: {width: '90%', height: '85%'},
            legend: { position: 'bottom', textStyle: { color: '#A89B8A', fontSize: 12 } },
            pieSliceBorderColor: 'transparent',
        };
        var roleChart = new google.visualization.PieChart(document.getElementById('role_pie_chart'));
        roleChart.draw(roleData, roleOptions);

        // Location Bar Chart
        var locationData = google.visualization.arrayToDataTable(@json($locationData));
        var locationOptions = {
            backgroundColor: 'transparent',
            colors: ['#C5A55A'],
            chartArea: {width: '65%', height: '80%'},
            legend: {position: 'none'},
            hAxis: {
                title: 'Programmes',
                minValue: 0,
                titleTextStyle: { color: '#8B7D6B' },
                textStyle: { color: '#8B7D6B' },
                baselineColor: 'rgba(197, 165, 90, 0.12)',
                gridlines: { color: 'rgba(197, 165, 90, 0.08)' }
            },
            vAxis: {
                textStyle: { color: '#A89B8A' },
                gridlines: { color: 'transparent' }
            },
            bar: { groupWidth: '60%' },
        };
        var locationChart = new google.visualization.BarChart(document.getElementById('location_bar_chart'));
        locationChart.draw(locationData, locationOptions);
    }
</script>
@endsection
