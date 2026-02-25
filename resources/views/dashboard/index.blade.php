@extends('layouts.app')

@section('title', 'Tableau de bord – Récapitulatif Épargnes')

@section('content')

    {{-- Filtres --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                <div class="col-auto">
                    <label class="form-label fw-semibold">Mois</label>
                    <select name="mois" class="form-select">
                        @foreach ($moisListe as $num => $nom)
                            <option value="{{ $num }}" @selected($num == $mois)>{{ $nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label fw-semibold">Année</label>
                    <select name="annee" class="form-select">
                        @foreach ($annees as $a)
                            <option value="{{ $a }}" @selected($a == $annee)>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-funnel me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('rapports.create') }}" class="btn btn-success btn-sm ms-2">
                        <i class="bi bi-plus-lg me-1"></i>&nbsp; Saisir un rapport
                    </a>
                    <a href="{{ route('dashboard.print', ['mois' => $mois, 'annee' => $annee]) }}"
                       target="_blank" class="btn btn-info btn-sm ms-2">
                        <i class="bi bi-printer me-1"></i>&nbsp; Imprimer
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Cartes KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#1a2942,#2e4680)">
                <div class="stat-label"><i class="bi bi-building me-1"></i>Total Warehouse</div>
                <div class="stat-value">{{ number_format($totalGlobal['warehouse'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#0d6e4e,#198754)">
                <div class="stat-label"><i class="bi bi-journal-text me-1"></i>Total Cahier</div>
                <div class="stat-value">{{ number_format($totalGlobal['cahier'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#0d7a8a,#17a2b8)">
                <div class="stat-label"><i class="bi bi-safe me-1"></i>Total Caisse</div>
                <div class="stat-value">{{ number_format($totalGlobal['caisse'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#6a0dad,#9b59b6)">
                <div class="stat-label"><i class="bi bi-file-earmark-check me-1"></i>Rapports G50</div>
                <div class="stat-value">{{ number_format($totalGlobal['rapports']) }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#9c3e00,#dc6015)">
                <div class="stat-label"><i class="bi bi-arrow-left-right me-1"></i>Total Écarts Cahier</div>
                <div class="stat-value">{{ number_format($totalGlobal['ecart'], 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#7b2d00,#c0392b)">
                <div class="stat-label"><i class="bi bi-arrow-left-right me-1"></i>Total Écarts Caisse</div>
                <div class="stat-value">{{ number_format($totalGlobal['ecart_caisse'], 0, ',', ' ') }}</div>
            </div>
        </div>
    </div>

    {{-- Tableau récapitulatif --}}
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <span class="fw-bold" style="color:#1a2942">
                <i class="bi bi-table me-2"></i>Récapitulatif des rapports d'épargnes
            </span>
            <span class="badge-mois">
                <i class="bi bi-calendar-month me-1"></i>
                {{ $moisListe[$mois] }} {{ $annee }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="font-size:.88rem">
                    <thead>
                        <tr>
                            <th style="width:160px">Région</th>
                            <th>Province</th>
                            <th class="text-end">Montant Warehouse</th>
                            <th class="text-end">Montant Cahier</th>
                            <th class="text-end">Montant Caisse</th>
                            <th class="text-end">Écart Cahier</th>
                            <th class="text-end">Écart Caisse</th>
                            <th class="text-end">Rapports G50</th>
                            <th class="text-center" style="width:80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regions as $region)
                            @php
                                $provinces = $region->provinces;
                                $first = true;
                            @endphp
                            @forelse($provinces as $province)
                                @php $rapport = $province->rapportEpargnes->first(); @endphp
                                <tr>
                                    @if ($first)
                                        <td rowspan="{{ $provinces->count() + 1 }}" class="fw-bold align-middle"
                                            style="background:#f8f9fb; color:#1a2942; vertical-align:middle; border-right: 3px solid #1a2942">
                                            {{ $region->nom }}
                                        </td>
                                        @php $first = false; @endphp
                                    @endif
                                    <td>{{ $province->nom }}</td>
                                    @if ($rapport)
                                        <td class="text-end">{{ number_format($rapport->montant_warehouse, 0, ',', ' ') }}</td>
                                        <td class="text-end">{{ number_format($rapport->montant_cahier, 0, ',', ' ') }}</td>
                                        <td class="text-end">{{ number_format($rapport->montant_caisse ?? 0, 0, ',', ' ') }}</td>
                                        <td class="text-end {{ $rapport->ecart < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($rapport->ecart, 0, ',', ' ') }}
                                        </td>
                                        <td class="text-end {{ $rapport->ecart_caisse_warehouse < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($rapport->ecart_caisse_warehouse, 0, ',', ' ') }}
                                        </td>
                                        <td class="text-end">{{ $rapport->rapports_g50 }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('rapports.edit', $rapport) }}"
                                                class="btn btn-sm btn-outline-primary btn-action" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td class="text-muted text-center" colspan="6" style="font-size:.8rem">— aucun rapport —</td>
                                        <td class="text-center">
                                            <a href="{{ route('rapports.create') }}?province_id={{ $province->id }}&mois={{ $mois }}&annee={{ $annee }}"
                                                class="btn btn-sm btn-outline-success btn-action" title="Saisir">
                                                <i class="bi bi-plus"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted" colspan="6">Aucune province.</td>
                                </tr>
                            @endforelse

                            {{-- Ligne total région --}}
                            <tr class="table-total">
                                <td class="text-center fw-bold" style="font-size:.8rem; letter-spacing:.04em; background:#8b8d8f5f;">
                                    TOTAL {{ strtoupper($region->nom) }}
                                </td>
                                <td class="text-end fw-bold" style="background:#8b8d8f5f;">{{ number_format($region->totaux['warehouse'], 0, ',', ' ') }}</td>
                                <td class="text-end fw-bold" style="background:#8b8d8f5f;">{{ number_format($region->totaux['cahier'], 0, ',', ' ') }}</td>
                                <td class="text-end fw-bold" style="background:#8b8d8f5f;">{{ number_format($region->totaux['caisse'], 0, ',', ' ') }}</td>
                                <td class="text-end fw-bold {{ $region->totaux['ecart'] < 0 ? 'text-danger' : 'text-success' }}" style="background:#8b8d8f5f;">
                                    {{ number_format($region->totaux['ecart'], 0, ',', ' ') }}
                                </td>
                                <td class="text-end fw-bold {{ $region->totaux['ecart_caisse'] < 0 ? 'text-danger' : 'text-success' }}" style="background:#8b8d8f5f;">
                                    {{ number_format($region->totaux['ecart_caisse'], 0, ',', ' ') }}
                                </td>
                                <td class="text-end fw-bold" style="background:#8b8d8f5f;">{{ $region->totaux['rapports'] }}</td>
                                <td style="background:#8b8d8f5f;"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucune donnée. <a href="{{ route('regions.create') }}">Créer une région</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Pied de tableau : total global --}}
                    @if ($regions->isNotEmpty())
                        <tfoot>
                            <tr style="background:#1a2942; color:#fff; font-weight:700; font-size:.88rem">
                                <td class="text-center" colspan="2">TOTAL GÉNÉRAL</td>
                                <td class="text-end">{{ number_format($totalGlobal['warehouse'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($totalGlobal['cahier'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($totalGlobal['caisse'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($totalGlobal['ecart'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($totalGlobal['ecart_caisse'], 0, ',', ' ') }}</td>
                                <td class="text-end">{{ number_format($totalGlobal['rapports']) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
