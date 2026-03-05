@extends('layouts.app')
@section('title', 'Modifier un montant ODK')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>
                    <strong>Modifier le montant ODK</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('montants-odk.update', $montantOdk) }}" method="POST">
                        @csrf @method('PUT')

                        {{-- Période (affichage seulement) --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-semibold">Mois</label>
                                <input type="text" class="form-control-plaintext fw-semibold"
                                       value="{{ $moisListe[$montantOdk->mois] }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-semibold">Année</label>
                                <input type="text" class="form-control-plaintext fw-semibold"
                                       value="{{ $montantOdk->annee }}" disabled>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Montant ODK (éditable) --}}
                        <div class="mb-3">
                            <label class="small fw-semibold">Montant ODK (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant_odk" min="0"
                                class="form-control @error('montant_odk') is-invalid @enderror"
                                value="{{ old('montant_odk', $montantOdk->montant_odk) }}" placeholder="0">
                            @error('montant_odk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Mettre à jour
                            </button>
                            <a href="{{ route('montants-odk.index', ['mois' => $montantOdk->mois, 'annee' => $montantOdk->annee]) }}"
                               class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
