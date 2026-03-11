@extends('layouts.app')

@section('title', 'Tableau de bord – Dashboard Global')

@section('content')

    <div class="d-flex gap-3 mb-4">
        <a href="{{ route('dashboard.global') }}" class="btn btn-lg"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);"
            onmouseover="this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.6)'; this.style.transform='translateY(-2px)'"
            onmouseout="this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.4)'; this.style.transform='translateY(0)'">
            <i class="bi bi-graph-up me-2"></i>Dashboard Global
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-lg"
            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);"
            onmouseover="this.style.boxShadow='0 6px 20px rgba(245, 87, 108, 0.6)'; this.style.transform='translateY(-2px)'"
            onmouseout="this.style.boxShadow='0 4px 15px rgba(245, 87, 108, 0.4)'; this.style.transform='translateY(0)'">
            <i class="bi bi-table me-2"></i>Dashboard Détaillé
        </a>
    </div>

    <hr class="my-4">

    {{-- Cartes KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#1a2942,#2e4680)">
                <div class="stat-label"><i class="bi bi-building me-1"></i>Montant Warehouse</div>
                <div class="stat-value">{{ number_format($totalGlobal['warehouse'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#0d6e4e,#198754)">
                <div class="stat-label"><i class="bi bi-journal-text me-1"></i>Montant Cahier</div>
                <div class="stat-value">{{ number_format($totalGlobal['cahier'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#0d7a8a,#17a2b8)">
                <div class="stat-label"><i class="bi bi-safe me-1"></i>Montant compte épargne (imf)</div>
                <div class="stat-value">{{ number_format($totalGlobal['caisse'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#8b5a00,#d4a500)">
                <div class="stat-label"><i class="bi bi-box-seam me-1"></i>Montant ODK</div>
                <div class="stat-value">{{ number_format($totalGlobal['odk'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#9c3e00,#dc6015)">
                <div class="stat-label"><i class="bi bi-arrow-left-right me-1"></i>Total écart CAHIER vs WH</div>
                <div class="stat-value {{ $totalGlobal['ecart'] < 0 ? 'text-danger' : 'text-white' }}">{{ number_format($totalGlobal['ecart'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#7b2d00,#c0392b)">
                <div class="stat-label"><i class="bi bi-arrow-left-right me-1"></i>Total écart compte épargne vs WH</div>
                <div class="stat-value {{ $totalGlobal['ecart_caisse'] < 0 ? 'text-danger' : 'text-white' }}">{{ number_format($totalGlobal['ecart_caisse'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#5a3800,#a0631f)">
                <div class="stat-label"><i class="bi bi-arrow-left-right me-1"></i>Total écart cahier vs ODK</div>
                <div class="stat-value {{ $totalGlobal['ecart_odk'] < 0 ? 'text-danger' : 'text-white' }}">{{ number_format($totalGlobal['ecart_odk'], 0, ',', ' ') }}</div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row g-3 mb-4">
        {{-- Évolution des montants --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Évolution des Épargnes</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartMontants" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        {{-- Répartition des sources --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Répartition des Sources d'Épargne</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartRepartition" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphique écarts --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-exclamation-circle me-2"></i>Vue d'Ensemble des Écarts</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartEcarts" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau récapitulatif par Province --}}
    <div class="card">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Détail par Province</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="font-size:.88rem">
                    <thead>
                        <tr>
                            <th>Province</th>
                            <th class="text-end">Montant Warehouse</th>
                            <th class="text-end">Montant Cahier</th>
                            <th class="text-end">Montant Caisse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donneesParProvince as $province)
                            <tr>
                                <td><strong>{{ $province['province'] }}</strong></td>
                                <td class="text-end">{{ number_format($province['warehouse'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($province['cahier'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($province['caisse'] ?? 0, 0, ',', ' ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Aucune donnée disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Préparer les données pour l'évolution mensuelle
        const donneesParMois = @json($donneesParMois);
        const moisLabels = donneesParMois.map(d => {
            const moisNoms = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            return moisNoms[d.mois - 1] + ' ' + d.annee;
        });

        const warehouseData = donneesParMois.map(d => d.total_warehouse || 0);
        const cahierData = donneesParMois.map(d => d.total_cahier || 0);
        const caisseData = donneesParMois.map(d => d.total_caisse || 0);
        const odkData = donneesParMois.map(d => d.total_odk || 0);

        // Calcul des pourcentages d'évolution par série
        function calcPct(data, idx) {
            if (idx === 0) return null;
            const prev = data[idx - 1];
            const curr = data[idx];
            if (prev === 0 && curr === 0) return null;
            if (prev === 0) return null;
            return ((curr - prev) / prev * 100).toFixed(1);
        }

        // Graphique évolution des montants
        const ctxMontants = document.getElementById('chartMontants').getContext('2d');
        new Chart(ctxMontants, {
            type: 'line',
            data: {
                labels: moisLabels,
                datasets: [
                    {
                        label: 'Warehouse',
                        data: warehouseData,
                        borderColor: 'red',
                        backgroundColor: 'rgba(26, 41, 66, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: 'red',
                        pointBorderColor: 'red',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Cahier',
                        data: cahierData,
                        borderColor: '#0d6e4e',
                        backgroundColor: 'rgba(13, 110, 78, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#0d6e4e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Compte épargne (IMF)',
                        data: caisseData,
                        borderColor: '#764ba2',
                        backgroundColor: 'rgba(13, 122, 138, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#764ba2',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'ODK',
                        data: odkData,
                        borderColor: '#d4a500',
                        backgroundColor: 'rgba(139, 90, 0, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#d4a500',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    datalabels: {
                        display: function(context) {
                            return context.dataIndex > 0;
                        },
                        formatter: function(value, context) {
                            const pct = calcPct(context.dataset.data, context.dataIndex);
                            if (pct === null) return '';
                            return (parseFloat(pct) >= 0 ? '+' : '') + pct + '%';
                        },
                        color: function(context) {
                            const pct = calcPct(context.dataset.data, context.dataIndex);
                            return pct !== null && parseFloat(pct) >= 0 ? '#198754' : '#c0392b';
                        },
                        font: { size: 10, weight: 'bold' },
                        anchor: 'end',
                        align: 'top',
                        offset: 2
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: { size: 12, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const current = context.raw;
                                const previous = idx > 0 ? context.dataset.data[idx - 1] : null;
                                let line = context.dataset.label + ': ' + new Intl.NumberFormat('fr-FR').format(current);
                                if (previous !== null && previous !== 0) {
                                    const pct = ((current - previous) / previous * 100).toFixed(1);
                                    const arrow = pct >= 0 ? '▲' : '▼';
                                    line += '  ' + arrow + ' ' + (pct >= 0 ? '+' : '') + pct + '%';
                                } else if (previous === 0 && current > 0) {
                                    line += '  ▲ nouveau';
                                }
                                return line;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value);
                            },
                            font: { size: 11 }
                        },
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                }
            }
        });

        // Graphique répartition
        const ctxRepartition = document.getElementById('chartRepartition').getContext('2d');
        new Chart(ctxRepartition, {
            type: 'doughnut',
            data: {
                labels: ['Warehouse', 'Cahier', 'Caisse (IMF)', 'ODK'],
                datasets: [{
                    data: [
                        {{ $totalGlobal['warehouse'] }},
                        {{ $totalGlobal['cahier'] }},
                        {{ $totalGlobal['caisse'] }},
                        {{ $totalGlobal['odk'] }}
                    ],
                    backgroundColor: [
                        'rgba(26, 41, 66, 0.8)',
                        'rgba(13, 110, 78, 0.8)',
                        'rgba(13, 122, 138, 0.8)',
                        'rgba(139, 90, 0, 0.8)'
                    ],
                    borderColor: [
                        '#1a2942',
                        '#0d6e4e',
                        '#0d7a8a',
                        '#8b5a00'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    datalabels: { display: false },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Graphique écarts
        const ctxEcarts = document.getElementById('chartEcarts').getContext('2d');
        new Chart(ctxEcarts, {
            type: 'bar',
            data: {
                labels: ['Cahier vs WH', 'Compte épargne (IMF) vs WH', 'ODK vs WH'],
                datasets: [{
                    label: 'Écarts',
                    data: [
                        {{ $totalGlobal['ecart'] }},
                        {{ $totalGlobal['ecart_caisse'] }},
                        {{ $totalGlobal['ecart_odk'] }}
                    ],
                    backgroundColor: function(context) {
                        const value = context.raw;
                        return value < 0 ? 'rgba(192, 57, 43, 0.8)' : 'rgba(26, 122, 74, 0.8)';
                    },
                    borderColor: function(context) {
                        const value = context.raw;
                        return value < 0 ? '#c0392b' : '#1a7a4a';
                    },
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y',
                plugins: {
                    datalabels: { display: false },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
