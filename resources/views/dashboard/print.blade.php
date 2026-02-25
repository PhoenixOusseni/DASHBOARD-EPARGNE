<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif Épargnes – {{ $moisListe[$mois] }} {{ $annee }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11pt;
            color: #1a1a1a;
            background: #fff;
            padding: 20px 30px;
        }

        /* ── En-tête ── */
        .print-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 3px solid #1a2942;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .print-header .org { font-size: 13pt; font-weight: 700; color: #1a2942; }
        .print-header .sub { font-size: 9pt; color: #555; margin-top: 3px; }
        .print-header .period-badge {
            text-align: right;
            background: #1a2942;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12pt;
            font-weight: 700;
            line-height: 1.4;
        }
        .print-header .period-badge small {
            display: block;
            font-size: 8pt;
            font-weight: 400;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* ── KPI ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
            margin-bottom: 18px;
        }
        .kpi-card {
            border: 1px solid #d0d7e2;
            border-radius: 6px;
            padding: 8px 10px;
            text-align: center;
        }
        .kpi-card .kpi-label {
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #666;
            margin-bottom: 4px;
        }
        .kpi-card .kpi-value {
            font-size: 11pt;
            font-weight: 700;
            color: #1a2942;
        }

        /* ── Tableau ── */
        .section-title {
            font-size: 10pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #1a2942;
            margin-bottom: 6px;
            border-left: 4px solid #1a2942;
            padding-left: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        thead th {
            background: #1a2942;
            color: #fff;
            padding: 7px 8px;
            text-align: left;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        thead th.text-end { text-align: right; }
        thead th.text-center { text-align: center; }

        tbody td {
            padding: 5px 8px;
            border-bottom: 1px solid #e8eaf0;
            vertical-align: middle;
        }
        tbody tr:nth-child(even) td { background: #f9fafc; }

        .td-region {
            background: #eef1f7 !important;
            font-weight: 700;
            font-size: 9pt;
            color: #1a2942;
            border-right: 3px solid #1a2942;
        }
        .tr-total td {
            background: #d6dce8 !important;
            font-weight: 700;
            font-size: 8.5pt;
            padding: 6px 8px;
            border-top: 1px solid #aab3c6;
        }
        .tr-grand-total td {
            background: #1a2942 !important;
            color: #fff !important;
            font-weight: 700;
            font-size: 9pt;
            padding: 7px 8px;
        }

        .text-end  { text-align: right; }
        .text-center { text-align: center; }
        .text-danger { color: #c0392b; }
        .text-success { color: #1a7a4a; }
        .text-muted { color: #999; text-align: center; }

        /* ── Pied de page ── */
        .print-footer {
            margin-top: 20px;
            border-top: 1px solid #d0d7e2;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 8pt;
            color: #888;
        }

        /* ── Bouton (masqué à l'impression) ── */
        .no-print {
            margin-bottom: 16px;
            display: flex;
            gap: 8px;
        }
        .btn-print {
            background: #1a2942;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 10pt;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back {
            background: #f4f6f9;
            color: #1a2942;
            border: 1px solid #c8cdd8;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 10pt;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media print {
            body { padding: 10px 15px; }
            .no-print { display: none !important; }
            thead th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .td-region { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .tr-total td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .tr-grand-total td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
        }

        @page { size: A4 landscape; margin: 15mm 12mm; }
    </style>
</head>
<body>

    {{-- Boutons (masqués à l'impression) --}}
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            🖨️ Imprimer / Enregistrer PDF
        </button>
        <a class="btn-back" href="{{ route('dashboard', ['mois' => $mois, 'annee' => $annee]) }}">
            ← Retour au tableau de bord
        </a>
    </div>

    {{-- En-tête --}}
    <div class="print-header">
        <div>
            <div class="org">Récapitulatif des Rapports d'Épargnes</div>
            <div class="sub">Dashboard Épargne — Document généré le {{ now()->format('d/m/Y à H:i') }}</div>
        </div>
        <div class="period-badge">
            <small>Période</small>
            {{ $moisListe[$mois] }} {{ $annee }}
        </div>
    </div>

    {{-- Cartes KPI --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total Warehouse</div>
            <div class="kpi-value">{{ number_format($totalGlobal['warehouse'], 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total Cahier</div>
            <div class="kpi-value">{{ number_format($totalGlobal['cahier'], 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total Caisse</div>
            <div class="kpi-value">{{ number_format($totalGlobal['caisse'], 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Écart Cahier</div>
            <div class="kpi-value {{ $totalGlobal['ecart'] < 0 ? 'text-danger' : 'text-success' }}">
                {{ number_format($totalGlobal['ecart'], 0, ',', ' ') }}
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Écart Caisse</div>
            <div class="kpi-value {{ $totalGlobal['ecart_caisse'] < 0 ? 'text-danger' : 'text-success' }}">
                {{ number_format($totalGlobal['ecart_caisse'], 0, ',', ' ') }}
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Rapports G50</div>
            <div class="kpi-value">{{ number_format($totalGlobal['rapports']) }}</div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="section-title">Détail par région et province</div>
    <table>
        <thead>
            <tr>
                <th style="width:150px">Région</th>
                <th>Province</th>
                <th class="text-end">Mnt. Warehouse</th>
                <th class="text-end">Mnt. Cahier</th>
                <th class="text-end">Mnt. Caisse</th>
                <th class="text-end">Écart Cahier</th>
                <th class="text-end">Écart Caisse</th>
                <th class="text-end text-center">G50</th>
            </tr>
        </thead>
        <tbody>
            @forelse($regions as $region)
                @php $provinces = $region->provinces; $first = true; @endphp
                @forelse($provinces as $province)
                    @php $rapport = $province->rapportEpargnes->first(); @endphp
                    <tr>
                        @if($first)
                            <td class="td-region" rowspan="{{ $provinces->count() + 1 }}" style="vertical-align:middle">
                                {{ $region->nom }}
                            </td>
                            @php $first = false; @endphp
                        @endif
                        <td>{{ $province->nom }}</td>
                        @if($rapport)
                            <td class="text-end">{{ number_format($rapport->montant_warehouse, 0, ',', ' ') }}</td>
                            <td class="text-end">{{ number_format($rapport->montant_cahier, 0, ',', ' ') }}</td>
                            <td class="text-end">{{ number_format($rapport->montant_caisse ?? 0, 0, ',', ' ') }}</td>
                            <td class="text-end {{ $rapport->ecart < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($rapport->ecart, 0, ',', ' ') }}
                            </td>
                            <td class="text-end {{ $rapport->ecart_caisse_warehouse < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($rapport->ecart_caisse_warehouse, 0, ',', ' ') }}
                            </td>
                            <td class="text-center">{{ $rapport->rapports_g50 }}</td>
                        @else
                            <td colspan="6" class="text-muted" style="font-size:8pt">— aucun rapport —</td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted">Aucune province.</td></tr>
                @endforelse

                {{-- Ligne total région --}}
                <tr class="tr-total">
                    <td class="text-center" style="font-size:8pt; letter-spacing:.04em">
                        TOTAL {{ strtoupper($region->nom) }}
                    </td>
                    <td class="text-end">{{ number_format($region->totaux['warehouse'], 0, ',', ' ') }}</td>
                    <td class="text-end">{{ number_format($region->totaux['cahier'], 0, ',', ' ') }}</td>
                    <td class="text-end">{{ number_format($region->totaux['caisse'], 0, ',', ' ') }}</td>
                    <td class="text-end {{ $region->totaux['ecart'] < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($region->totaux['ecart'], 0, ',', ' ') }}
                    </td>
                    <td class="text-end {{ $region->totaux['ecart_caisse'] < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($region->totaux['ecart_caisse'], 0, ',', ' ') }}
                    </td>
                    <td class="text-center">{{ $region->totaux['rapports'] }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-muted" style="padding:20px">Aucune donnée pour cette période.</td></tr>
            @endforelse
        </tbody>

        @if($regions->isNotEmpty())
        <tfoot>
            <tr class="tr-grand-total">
                <td colspan="2" class="text-center">TOTAL GÉNÉRAL</td>
                <td class="text-end">{{ number_format($totalGlobal['warehouse'], 0, ',', ' ') }}</td>
                <td class="text-end">{{ number_format($totalGlobal['cahier'], 0, ',', ' ') }}</td>
                <td class="text-end">{{ number_format($totalGlobal['caisse'], 0, ',', ' ') }}</td>
                <td class="text-end">{{ number_format($totalGlobal['ecart'], 0, ',', ' ') }}</td>
                <td class="text-end">{{ number_format($totalGlobal['ecart_caisse'], 0, ',', ' ') }}</td>
                <td class="text-center">{{ number_format($totalGlobal['rapports']) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- Pied de page --}}
    <div class="print-footer">
        <span>Dashboard Épargne</span>
        <span>{{ $moisListe[$mois] }} {{ $annee }}</span>
        <span>Imprimé le {{ now()->format('d/m/Y à H:i') }}</span>
    </div>

</body>
</html>
