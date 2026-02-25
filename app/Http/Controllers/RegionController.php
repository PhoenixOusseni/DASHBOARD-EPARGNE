<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::withCount('provinces')->orderBy('nom')->paginate(15);
        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        return view('regions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:regions,nom',
        ]);

        Region::create(['nom' => strtoupper(trim($request->nom))]);

        return redirect()->route('regions.index')
            ->with('success', 'Région créée avec succès.');
    }

    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:regions,nom,' . $region->id,
        ]);

        $region->update(['nom' => strtoupper(trim($request->nom))]);

        return redirect()->route('regions.index')
            ->with('success', 'Région mise à jour avec succès.');
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')
            ->with('success', 'Région supprimée avec succès.');
    }
}
