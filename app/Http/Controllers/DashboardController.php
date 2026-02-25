<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $mois  = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        // Toutes les régions avec leurs provinces et rapports du mois/année sélectionnés
        $regions = Region::with(['provinces.rapportEpargnes' => function ($q) use ($mois, $annee) {
            $q->where('mois', $mois)->where('annee', $annee);
        }])->orderBy('nom')->get();

        // Calcul des totaux globaux
        $totalGlobal = [
            'warehouse'    => 0,
            'cahier'       => 0,
            'caisse'       => 0,
            'ecart'        => 0,
            'ecart_caisse' => 0,
            'rapports'     => 0,
        ];

        foreach ($regions as $region) {
            $region->totaux = $this->calcTotauxRegion($region);
            $totalGlobal['warehouse']    += $region->totaux['warehouse'];
            $totalGlobal['cahier']       += $region->totaux['cahier'];
            $totalGlobal['caisse']       += $region->totaux['caisse'];
            $totalGlobal['ecart']        += $region->totaux['ecart'];
            $totalGlobal['ecart_caisse'] += $region->totaux['ecart_caisse'];
            $totalGlobal['rapports']     += $region->totaux['rapports'];
        }

        $moisListe = $this->listeMois();
        $annees    = range(now()->year - 3, now()->year + 1);

        return view('dashboard.index', compact(
            'regions', 'totalGlobal', 'mois', 'annee', 'moisListe', 'annees'
        ));
    }

    public function print(Request $request)
    {
        $mois  = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        $regions = Region::with(['provinces.rapportEpargnes' => function ($q) use ($mois, $annee) {
            $q->where('mois', $mois)->where('annee', $annee);
        }])->orderBy('nom')->get();

        $totalGlobal = [
            'warehouse'    => 0,
            'cahier'       => 0,
            'caisse'       => 0,
            'ecart'        => 0,
            'ecart_caisse' => 0,
            'rapports'     => 0,
        ];

        foreach ($regions as $region) {
            $region->totaux = $this->calcTotauxRegion($region);
            $totalGlobal['warehouse']    += $region->totaux['warehouse'];
            $totalGlobal['cahier']       += $region->totaux['cahier'];
            $totalGlobal['caisse']       += $region->totaux['caisse'];
            $totalGlobal['ecart']        += $region->totaux['ecart'];
            $totalGlobal['ecart_caisse'] += $region->totaux['ecart_caisse'];
            $totalGlobal['rapports']     += $region->totaux['rapports'];
        }

        $moisListe = $this->listeMois();

        return view('dashboard.print', compact(
            'regions', 'totalGlobal', 'mois', 'annee', 'moisListe'
        ));
    }

    private function calcTotauxRegion(Region $region): array
    {
        $totaux = ['warehouse' => 0, 'cahier' => 0, 'caisse' => 0, 'ecart' => 0, 'ecart_caisse' => 0, 'rapports' => 0];

        foreach ($region->provinces as $province) {
            $rapport = $province->rapportEpargnes->first();
            if ($rapport) {
                $totaux['warehouse']    += $rapport->montant_warehouse;
                $totaux['cahier']       += $rapport->montant_cahier;
                $totaux['caisse']       += $rapport->montant_caisse ?? 0;
                $totaux['ecart']        += $rapport->ecart;
                $totaux['ecart_caisse'] += $rapport->ecart_caisse_warehouse;
                $totaux['rapports']     += $rapport->rapports_g50;
            }
        }

        return $totaux;
    }

    private function listeMois(): array
    {
        return [
            1  => 'Janvier',   2  => 'Février',   3  => 'Mars',
            4  => 'Avril',     5  => 'Mai',        6  => 'Juin',
            7  => 'Juillet',   8  => 'Août',       9  => 'Septembre',
            10 => 'Octobre',   11 => 'Novembre',   12 => 'Décembre',
        ];
    }
}
