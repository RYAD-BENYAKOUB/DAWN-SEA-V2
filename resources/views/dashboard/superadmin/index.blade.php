@extends('layouts.app')

@section('title', __('Tableau de bord Administration') . ' — Dawn & Sea')

@section('content')
<div class="ds-container" style="padding: 4rem 0;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 3rem;">
        <div>
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ __('Tableau de bord Global') }}</h1>
            <p style="color: var(--charcoal-soft);">{{ __('Vue d\'ensemble des statistiques et données du site.') }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('dashboard.users.index') }}" class="ds-btn ds-btn-secondary">
                {{ __('Gérer les utilisateurs') }}
            </a>
            <a href="{{ route('profile.edit') }}" class="ds-btn ds-btn-primary">
                {{ __('Mon Profil') }}
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
        <div class="ds-stat-card">
            <div class="ds-stat-icon">👥</div>
            <div class="ds-stat-value">{{ $totalUsers }}</div>
            <div class="ds-stat-label">{{ __('Utilisateurs Inscrits') }}</div>
        </div>
        <div class="ds-stat-card">
            <div class="ds-stat-icon">🗺️</div>
            <div class="ds-stat-value">{{ $totalGuides }}</div>
            <div class="ds-stat-label">{{ __('Guides Locaux') }}</div>
        </div>
        <div class="ds-stat-card">
            <div class="ds-stat-icon">📅</div>
            <div class="ds-stat-value">{{ $totalPrograms }}</div>
            <div class="ds-stat-label">{{ __('Programmes Actifs') }}</div>
        </div>
    </div>

    <!-- Google Charts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
        <div class="ds-card ds-card-body">
            <h3 class="ds-card-title">{{ __('Répartition des utilisateurs') }}</h3>
            <div id="role_pie_chart" style="width: 100%; height: 350px;"></div>
        </div>
        <div class="ds-card ds-card-body">
            <h3 class="ds-card-title">{{ __('Programmes par destination') }}</h3>
            <div id="location_bar_chart" style="width: 100%; height: 350px;"></div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="ds-card ds-card-body">
        <h3 class="ds-card-title">{{ __('Inscriptions récentes') }}</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1.5rem;">
            <thead>
                <tr style="border-bottom: 2px solid var(--cream-dark); text-align: left;">
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Nom') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Email') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Rôle') }}</th>
                    <th style="padding: 1rem 0.5rem; color: var(--taupe); font-weight: 600;">{{ __('Inscription') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $user)
                <tr style="border-bottom: 1px solid var(--cream-dark);">
                    <td style="padding: 1rem 0.5rem; font-weight: 500;">{{ $user->name }}</td>
                    <td style="padding: 1rem 0.5rem; color: var(--charcoal-soft);">{{ $user->email }}</td>
                    <td style="padding: 1rem 0.5rem;">
                        <span class="ds-badge {{ $user->role === 'superadmin' ? 'ds-badge-gold' : ($user->role === 'admin' ? 'ds-badge-success' : '') }}" style="background: var(--cream-dark); color: var(--charcoal);">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: var(--charcoal-soft);">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Load Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Role Pie Chart
        var roleData = google.visualization.arrayToDataTable(@json($roleData));
        var roleOptions = {
            pieHole: 0.4,
            colors: ['#2C2C2C', '#C5A55A', '#6B8E6B'],
            chartArea: {width: '80%', height: '80%'},
            legend: {position: 'bottom'}
        };
        var roleChart = new google.visualization.PieChart(document.getElementById('role_pie_chart'));
        roleChart.draw(roleData, roleOptions);

        // Location Bar Chart
        var locationData = google.visualization.arrayToDataTable(@json($locationData));
        var locationOptions = {
            colors: ['#C5A55A'],
            chartArea: {width: '70%', height: '80%'},
            legend: {position: 'none'},
            hAxis: {title: 'Programmes', minValue: 0},
            vAxis: {title: 'Destination'}
        };
        var locationChart = new google.visualization.BarChart(document.getElementById('location_bar_chart'));
        locationChart.draw(locationData, locationOptions);
    }
</script>
@endsection
