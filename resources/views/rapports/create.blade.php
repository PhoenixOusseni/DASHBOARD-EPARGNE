@extends('layouts.app')
@section('title', 'Saisir un rapport d\'épargne')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <i class="bi bi-pencil-square me-2 text-success"></i>
                    <strong>Nouveau rapport d'épargne</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('rapports.store') }}" method="POST">
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

                        {{-- Province --}}
                        <div class="mb-3">
                            <label class="small fw-semibold">Province <span class="text-danger">*</span></label>
                            <select name="province_id" class="form-select @error('province_id') is-invalid @enderror">
                                <option value="">-- Sélectionner une province --</option>
                                @foreach ($provinces->groupBy(fn($p) => $p->region->nom) as $regionNom => $provs)
                                    <optgroup label="{{ $regionNom }}">
                                        @foreach ($provs as $p)
                                            <option value="{{ $p->id }}" @selected(old('province_id', request('province_id')) == $p->id)>
                                                {{ $p->nom }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- Montants --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-semibold">Montant sur Warehouse (FCFA) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="montant_warehouse" min="0"
                                    class="form-control @error('montant_warehouse') is-invalid @enderror"
                                    value="{{ old('montant_warehouse', 0) }}">
                                @error('montant_warehouse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-semibold">Montant sur Cahier (FCFA) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="montant_cahier" min="0"
                                    class="form-control @error('montant_cahier') is-invalid @enderror"
                                    value="{{ old('montant_cahier', 0) }}">
                                @error('montant_cahier')

                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-semibold">Montant sur Caisse (FCFA) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="montant_caisse" min="0"
                                    class="form-control @error('montant_caisse') is-invalid @enderror"
                                    value="{{ old('montant_caisse', 0) }}">
                                @error('montant_caisse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-semibold">Rapports G50 Épargnes Arrivés <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="rapports_g50" min="0"
                                    class="form-control @error('rapports_g50') is-invalid @enderror"
                                    value="{{ old('rapports_g50', 0) }}">
                                @error('rapports_g50')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-semibold text-muted">Écart (Cahier – Warehouse)</label>
                                <input type="text" class="form-control bg-light text-muted" id="ecart_cahier_warehouse"
                                    readonly placeholder="Cahier – Warehouse">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-semibold text-muted">Écart (Caisse – Warehouse)</label>
                                <input type="text" class="form-control bg-light text-muted" id="ecart_caisse_warehouse"
                                    readonly placeholder="Caisse – Warehouse">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer le rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const warehouse = document.querySelector('[name="montant_warehouse"]');
        const cahier = document.querySelector('[name="montant_cahier"]');
        const caisse = document.querySelector('[name="montant_caisse"]');
        const odk = document.querySelector('[name="montant_odk"]');
        const ecartCahierWarehouse = document.getElementById('ecart_cahier_warehouse');
        const ecartCaisseWarehouse = document.getElementById('ecart_caisse_warehouse');

        function updateEcart() {
            const diffCahierWarehouse = (parseInt(cahier.value) || 0) - (parseInt(warehouse.value) || 0);
            ecartCahierWarehouse.value = diffCahierWarehouse.toLocaleString('fr-FR');
            ecartCahierWarehouse.style.color = diffCahierWarehouse < 0 ? '#dc3545' : '#198754';

            const diffCaisseWarehouse = (parseInt(caisse.value) || 0) - (parseInt(warehouse.value) || 0);
            ecartCaisseWarehouse.value = diffCaisseWarehouse.toLocaleString('fr-FR');
            ecartCaisseWarehouse.style.color = diffCaisseWarehouse < 0 ? '#dc3545' : '#198754';
        }

        warehouse.addEventListener('input', updateEcart);
        cahier.addEventListener('input', updateEcart);
        caisse.addEventListener('input', updateEcart);
        odk.addEventListener('input', updateEcart);
        updateEcart();
    </script>
@endpush
