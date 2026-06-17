@extends('layouts.dashboard')

@section('title', __('Tableau de Bord') . ' — Dawn & Sea')

@section('dashboard_content')
<!-- Welcome Banner -->
<div class="ds-welcome-banner">
    <div class="ds-sidebar-avatar-placeholder" style="width:64px; height:64px; font-size:1.5rem; flex-shrink:0;">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
    <div>
        <h2 style="margin-bottom:0.25rem;">{{ __('Bonjour') }}, {{ Auth::user()->name }} 👋</h2>
        <p style="margin:0;">{{ __('Voici un aperçu de votre activité en tant que guide.') }} — {{ now()->translatedFormat('l j F Y') }}</p>
    </div>
</div>

<!-- KPI Stats Grid -->
<div class="ds-grid-4" style="margin-bottom:2rem;">
    <div class="ds-stat-card ds-animate-in ds-animate-delay-1">
        <div class="ds-stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <div class="ds-stat-value">{{ number_format($stats['total_visits'] ?? 1247) }}</div>
        <div class="ds-stat-label">{{ __('Visites totales') }}</div>
        <div class="ds-stat-trend up">↑ +12% {{ __('ce mois') }}</div>
    </div>

    <div class="ds-stat-card ds-animate-in ds-animate-delay-2">
        <div class="ds-stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div class="ds-stat-value">{{ $stats['active_programs'] ?? 8 }}</div>
        <div class="ds-stat-label">{{ __('Programmes actifs') }}</div>
        <div class="ds-stat-trend up">↑ +2 {{ __('nouveau') }}</div>
    </div>

    <div class="ds-stat-card ds-animate-in ds-animate-delay-3">
        <div class="ds-stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div class="ds-stat-value">{{ $stats['favorites_received'] ?? 342 }}</div>
        <div class="ds-stat-label">{{ __('Favoris reçus') }}</div>
        <div class="ds-stat-trend up">↑ +28 {{ __('ce mois') }}</div>
    </div>

    <div class="ds-stat-card ds-animate-in ds-animate-delay-4">
        <div class="ds-stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="ds-stat-value">{{ $stats['rating'] ?? '4.9' }}</div>
        <div class="ds-stat-label">{{ __('Note moyenne') }}</div>
        <div class="ds-stars" style="margin-top:0.5rem;">
            @for($i = 0; $i < 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            @endfor
        </div>
    </div>
</div>

<!-- Chart + Recent Activity -->
<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; margin-bottom:2rem;">
    <!-- Visits Chart -->
    <div class="ds-chart-card">
        <div class="ds-chart-header">
            <h3 class="ds-chart-title">{{ __('Statistiques de visites') }}</h3>
            <span class="ds-badge ds-badge-taupe">{{ __('12 derniers mois') }}</span>
        </div>
        <div id="visits-chart" style="width:100%; height:300px;"></div>
    </div>

    <!-- Recent Favorites -->
    <div class="ds-card-static">
        <div class="ds-card-body">
            <h3 class="ds-chart-title" style="margin-bottom:1.25rem;">{{ __('Favoris récents') }}</h3>

            @forelse($recentFavorites ?? [] as $fav)
                <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 0; border-bottom:1px solid rgba(168,155,138,0.1);">
                    <div class="ds-sidebar-avatar-placeholder" style="width:36px; height:36px; font-size:0.8rem; flex-shrink:0;">
                        {{ strtoupper(substr($fav->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-weight:600; font-size:0.85rem; color:var(--charcoal);">{{ $fav->user->name ?? 'Utilisateur' }}</div>
                        <div style="font-size:0.75rem; color:var(--taupe); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ __('a aimé') }} {{ $fav->program->title ?? 'Programme' }}</div>
                    </div>
                </div>
            @empty
                @for($i = 0; $i < 5; $i++)
                    <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 0; border-bottom:1px solid rgba(168,155,138,0.1);">
                        <div class="ds-sidebar-avatar-placeholder" style="width:36px; height:36px; font-size:0.8rem; flex-shrink:0;">
                            {{ chr(65 + $i) }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.85rem; color:var(--charcoal);">{{ ['Sara M.', 'Karim B.', 'Leila H.', 'Omar T.', 'Nadia K.'][$i] }}</div>
                            <div style="font-size:0.75rem; color:var(--taupe);">{{ __('a aimé') }} {{ ['Sahara Doré', 'Côte Turquoise', 'Héritage Ottoman', 'Sahara Doré', 'Côte Turquoise'][$i] }}</div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</div>

<!-- Programs Table -->
<div class="ds-card-static">
    <div class="ds-card-body">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h3 class="ds-chart-title">{{ __('Mes Programmes') }}</h3>
            <a href="{{ url('/dashboard/programs/create') }}" class="ds-btn ds-btn-primary ds-btn-sm">
                + {{ __('Nouveau') }}
            </a>
        </div>

        <table class="ds-table">
            <thead>
                <tr>
                    <th>{{ __('Programme') }}</th>
                    <th>{{ __('Lieu') }}</th>
                    <th>{{ __('Prix') }}</th>
                    <th>{{ __('Statut') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs ?? [] as $program)
                    <tr>
                        <td style="font-weight:600; color:var(--charcoal);">{{ $program->title }}</td>
                        <td>{{ $program->location }}</td>
                        <td><span class="ds-price" style="font-size:1rem;">{{ number_format($program->price, 0, ',', ' ') }}</span> <span class="ds-price-currency">DA</span></td>
                        <td>
                            @if($program->is_active)
                                <span class="ds-badge ds-badge-success">{{ __('Actif') }}</span>
                            @else
                                <span class="ds-badge ds-badge-error">{{ __('Inactif') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/dashboard/programs/' . $program->id . '/edit') }}" class="ds-btn ds-btn-ghost ds-btn-sm">{{ __('Modifier') }}</a>
                        </td>
                    </tr>
                @empty
                    @php
                        $demoRows = [
                            ['title' => 'Sahara Doré', 'location' => 'Djanet', 'price' => '45 000', 'active' => true],
                            ['title' => 'Côte Turquoise', 'location' => 'Jijel', 'price' => '25 000', 'active' => true],
                            ['title' => 'Héritage Ottoman', 'location' => 'Constantine', 'price' => '35 000', 'active' => true],
                            ['title' => 'Oasis Mystique', 'location' => 'Ghardaïa', 'price' => '30 000', 'active' => false],
                        ];
                    @endphp
                    @foreach($demoRows as $row)
                        <tr>
                            <td style="font-weight:600; color:var(--charcoal);">{{ $row['title'] }}</td>
                            <td>{{ $row['location'] }}</td>
                            <td><span class="ds-price" style="font-size:1rem;">{{ $row['price'] }}</span> <span class="ds-price-currency">DA</span></td>
                            <td>
                                @if($row['active'])
                                    <span class="ds-badge ds-badge-success">{{ __('Actif') }}</span>
                                @else
                                    <span class="ds-badge ds-badge-error">{{ __('Inactif') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="ds-btn ds-btn-ghost ds-btn-sm">{{ __('Modifier') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chartData = @json($chartData ?? [
            ['Mois', 'Visites'],
            ['Jul', 85], ['Aoû', 120], ['Sep', 95], ['Oct', 140],
            ['Nov', 110], ['Déc', 165], ['Jan', 130], ['Fév', 155],
            ['Mar', 190], ['Avr', 210], ['Mai', 245], ['Jun', 280]
        ]);

        var data = google.visualization.arrayToDataTable(chartData);

        var options = {
            curveType: 'function',
            legend: { position: 'none' },
            colors: ['#C5A55A'],
            backgroundColor: 'transparent',
            chartArea: { width: '90%', height: '80%' },
            hAxis: {
                textStyle: { color: '#8B7D6B', fontSize: 12, fontName: 'Inter' },
                gridlines: { color: 'transparent' },
                baselineColor: '#E8E0D4'
            },
            vAxis: {
                textStyle: { color: '#8B7D6B', fontSize: 12, fontName: 'Inter' },
                gridlines: { color: '#F5F0E8', count: 5 },
                baselineColor: '#E8E0D4',
                minValue: 0
            },
            lineWidth: 3,
            pointSize: 6,
            pointShape: 'circle',
            areaOpacity: 0.08,
            tooltip: {
                textStyle: { fontName: 'Inter', fontSize: 13 }
            },
            animation: {
                startup: true,
                duration: 800,
                easing: 'out'
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('visits-chart'));
        chart.draw(data, options);
    }

    // Responsive chart
    window.addEventListener('resize', function() {
        drawChart();
    });
</script>
@endpush
