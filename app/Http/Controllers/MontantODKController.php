<?php

namespace App\Http\Controllers;

use App\Models\MontantODK;
use Illuminate\Http\Request;

class MontantODKController extends Controller
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

        $montants = MontantODK::where('mois', $mois)->where('annee', $annee)->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $annees = range(now()->year - 3, now()->year + 1);

        return view('montant_odk.index', compact('montants', 'mois', 'annee', 'annees'));
    }

    public function create()
    {
        $annees = range(now()->year - 3, now()->year + 1);

        return view('montant_odk.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant_odk' => 'required|integer|min:0',
        ]);

        // Vérification unicité province/mois/année
        $exists = MontantODK::where('mois', $data['mois'])->where('annee', $data['annee'])->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'mois' => 'Un montant ODK existe déjà pour ce mois/année.',
                ])->withInput();
        }

        MontantODK::create($data);

        return redirect()
            ->route('montants-odk.index', ['mois' => $data['mois'], 'annee' => $data['annee']])
            ->with('success', 'Montant ODK enregistré avec succès.');
    }

    public function edit(String $id)
    {
        $montantOdk = MontantODK::findOrFail($id);
        $annees = range(now()->year - 3, now()->year + 1);
        $moisListe = $this->moisListe;

        return view('montant_odk.edit', compact('montantOdk', 'annees', 'moisListe'));
    }

    public function update(Request $request, String $id)
    {
        $montantOdk = MontantODK::findOrFail($id);
        $data = $request->validate([
            'montant_odk' => 'required|integer|min:0',
        ]);

        $montantOdk->update($data);

        return redirect()
            ->route('montants-odk.index', ['mois' => $montantOdk->mois, 'annee' => $montantOdk->annee])
            ->with('success', 'Montant ODK mis à jour avec succès.');
    }

    public function destroy(String $id)
    {
        $montantOdk = MontantODK::findOrFail($id);
        $mois = $montantOdk->mois;
        $annee = $montantOdk->annee;
        $montantOdk->delete();

        return redirect()->route('montants-odk.index', compact('mois', 'annee'))->with('success', 'Montant ODK supprimé.');
    }
}
