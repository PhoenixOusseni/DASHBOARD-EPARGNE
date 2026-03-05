@extends('layouts.app')
@section('title', 'Saisir un montant ODK')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <i class="bi bi-calculator me-2 text-success"></i>
                    <strong>Nouveau montant ODK</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('montants-odk.store') }}" method="POST">
                        @csrf

                        {{-- Période --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-semibold">Mois <span class="text-danger">*</span></label>
                                <select name="mois" class="form-select @error('mois') is-invalid @enderror">
                                    @foreach ([1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'] as $n => $nom)
                                        <option value="{{ $n }}" @selected(old('mois', request('mois', now()->month)) == $n)>
                                            {{ $nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mois')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-semibold">Année <span class="text-danger">*</span></label>
                                <select name="annee" class="form-select @error('annee') is-invalid @enderror">
                                    @foreach ($annees as $a)
                                        <option value="{{ $a }}" @selected(old('annee', request('annee', now()->year)) == $a)>
                                            {{ $a }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('annee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Montant ODK --}}
                        <div class="mb-3">
                            <label class="small fw-semibold">Montant ODK (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant_odk" min="0"
                                class="form-control @error('montant_odk') is-invalid @enderror"
                                value="{{ old('montant_odk', 0) }}" placeholder="0">
                            @error('montant_odk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                            <a href="{{ route('montants-odk.index') }}" class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
