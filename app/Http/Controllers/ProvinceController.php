<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::with('region')->orderBy('nom')->paginate(20);
        return view('provinces.index', compact('provinces'));
    }

    public function create()
    {
        $regions = Region::orderBy('nom')->get();
        return view('provinces.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'nom'       => 'required|string|max:100',
        ]);

        Province::create([
            'region_id' => $request->region_id,
            'nom'       => ucfirst(trim($request->nom)),
        ]);

        return redirect()->route('provinces.index')
            ->with('success', 'Province créée avec succès.');
    }

    public function edit(Province $province)
    {
        $regions = Region::orderBy('nom')->get();
        return view('provinces.edit', compact('province', 'regions'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'nom'       => 'required|string|max:100',
        ]);

        $province->update([
            'region_id' => $request->region_id,
            'nom'       => ucfirst(trim($request->nom)),
        ]);

        return redirect()->route('provinces.index')
            ->with('success', 'Province mise à jour avec succès.');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('provinces.index')
            ->with('success', 'Province supprimée avec succès.');
    }
}
