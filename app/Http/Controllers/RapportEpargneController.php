<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\RapportEpargne;
use Illuminate\Http\Request;

class RapportEpargneController extends Controller
{
    private array $moisListe = [
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Décembre',
    ];

    public function index(Request $request)
    {
        $mois = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        $rapports = RapportEpargne::with('province.region')->where('mois', $mois)->where('annee', $annee)->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $annees = range(now()->year - 3, now()->year + 1);

        return view('rapports.index', compact('rapports', 'mois', 'annee', 'annees'));
    }

    public function create()
    {
        $provinces = Province::with('region')->orderBy('nom')->get();
        $annees = range(now()->year - 3, now()->year + 1);

        return view('rapports.create', compact('provinces', 'annees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant_warehouse' => 'required|integer|min:0',
            'montant_cahier' => 'required|integer|min:0',
            'montant_caisse' => 'required|integer|min:0',
            'rapports_g50' => 'required|integer|min:0',
        ]);

        // Vérification unicité province/mois/année
        $exists = RapportEpargne::where('province_id', $data['province_id'])->where('mois', $data['mois'])->where('annee', $data['annee'])->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'province_id' => 'Un rapport existe déjà pour cette province sur ce mois/année.',
                ])->withInput();
        }

        RapportEpargne::create($data);

        return redirect()
            ->route('rapports.index', ['mois' => $data['mois'], 'annee' => $data['annee']])
            ->with('success', 'Rapport enregistré avec succès.');
    }

    public function edit(RapportEpargne $rapport)
    {
        $provinces = Province::with('region')->orderBy('nom')->get();
        $annees = range(now()->year - 3, now()->year + 1);
        $moisListe = $this->moisListe;

        return view('rapports.edit', compact('rapport', 'provinces', 'annees', 'moisListe'));
    }

    public function update(Request $request, RapportEpargne $rapport)
    {
        $data = $request->validate([
            'montant_warehouse' => 'required|integer|min:0',
            'montant_cahier' => 'required|integer|min:0',
            'montant_caisse' => 'required|integer|min:0',
            'rapports_g50' => 'required|integer|min:0',
        ]);

        $rapport->update($data);

        return redirect()
            ->route('rapports.index', ['mois' => $rapport->mois, 'annee' => $rapport->annee])
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    public function destroy(RapportEpargne $rapport)
    {
        $mois = $rapport->mois;
        $annee = $rapport->annee;
        $rapport->delete();

        return redirect()->route('rapports.index', compact('mois', 'annee'))->with('success', 'Rapport supprimé.');
    }
}
