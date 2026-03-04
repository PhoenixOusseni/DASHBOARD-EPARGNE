<?php

namespace App\Http\Controllers;

use App\Models\RapportEpargne;
use Illuminate\Http\Request;

class DashboardGlobalController extends Controller
{
    public function index()
    {
        // Récupérer tous les rapports
        $rapports = RapportEpargne::all();

        // Calculer les totaux globaux (tous les mois/années confondus)
        $totalGlobal = [
            'warehouse'    => 0,
            'cahier'       => 0,
            'caisse'       => 0,
            'odk'          => 0,
            'ecart'        => 0,
            'ecart_caisse' => 0,
            'ecart_odk'    => 0,
        ];

        foreach ($rapports as $rapport) {
            $totalGlobal['warehouse']    += $rapport->montant_warehouse;
            $totalGlobal['cahier']       += $rapport->montant_cahier;
            $totalGlobal['caisse']       += $rapport->montant_caisse ?? 0;
            $totalGlobal['odk']          += $rapport->montant_odk ?? 0;
            $totalGlobal['ecart']        += $rapport->ecart;
            $totalGlobal['ecart_caisse'] += $rapport->ecart_caisse_warehouse;
            $totalGlobal['ecart_odk']    += $rapport->ecart_odk_warehouse;
        }

        // Récupérer les données par province pour les graphiques
        $donneesParProvince = RapportEpargne::with('province')
            ->get()
            ->groupBy('province_id')
            ->map(function ($rapportsProvince) {
                return [
                    'province' => $rapportsProvince->first()->province->nom,
                    'warehouse' => $rapportsProvince->sum('montant_warehouse'),
                    'cahier' => $rapportsProvince->sum('montant_cahier'),
                    'caisse' => $rapportsProvince->sum('montant_caisse'),
                    'odk' => $rapportsProvince->sum('montant_odk'),
                ];
            })
            ->sortBy('province')
            ->values();

        // Récupérer les données par mois pour graphique de tendance
        $donneesParMois = RapportEpargne::selectRaw('mois, annee, SUM(montant_warehouse) as total_warehouse, SUM(montant_cahier) as total_cahier, SUM(montant_caisse) as total_caisse, SUM(montant_odk) as total_odk')
            ->groupBy('mois', 'annee')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        return view('dashboard.dashboard_global', compact('totalGlobal', 'donneesParProvince', 'donneesParMois'));
    }
}
