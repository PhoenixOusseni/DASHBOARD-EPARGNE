@extends('layouts.app')
@section('title', 'Modifier le rapport')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <i class="bi bi-pencil-square me-2 text-primary"></i>
                <strong>Modifier le rapport</strong>
                <span class="text-muted ms-2 fw-normal" style="font-size:.9rem">
                    {{ $rapport->province->nom }} – {{ $rapport->nom_mois }} {{ $rapport->annee }}
                </span>
            </div>
            <div class="card-body">

                {{-- Info lecture seule --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Province</label>
                        <input type="text" class="form-control bg-light" value="{{ $rapport->province->nom }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Mois</label>
                        <input type="text" class="form-control bg-light" value="{{ $moisListe[$rapport->mois] }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Année</label>
                        <input type="text" class="form-control bg-light" value="{{ $rapport->annee }}" readonly>
                    </div>
                </div>

                <hr class="my-3">

                <form action="{{ route('rapports.update', $rapport) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Montant sur Warehouse (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant_warehouse" min="0"
                                   class="form-control @error('montant_warehouse') is-invalid @enderror"
                                   value="{{ old('montant_warehouse', $rapport->montant_warehouse) }}">
                            @error('montant_warehouse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Montant sur Cahier (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant_cahier" min="0"
                                   class="form-control @error('montant_cahier') is-invalid @enderror"
                                   value="{{ old('montant_cahier', $rapport->montant_cahier) }}">
                            @error('montant_cahier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Montant Caisse (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant_caisse" min="0"
                                   class="form-control @error('montant_caisse') is-invalid @enderror"
                                   value="{{ old('montant_caisse', $rapport->montant_caisse) }}">
                            @error('montant_caisse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rapports G50 Épargnes Arrivés <span class="text-danger">*</span></label>
                            <input type="number" name="rapports_g50" min="0"
                                   class="form-control @error('rapports_g50') is-invalid @enderror"
                                   value="{{ old('rapports_g50', $rapport->rapports_g50) }}">
                            @error('rapports_g50')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Écart (Cahier – Warehouse)</label>
                            <input type="text" class="form-control bg-light" id="ecart_display" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Écart (Caisse – Warehouse)</label>
                            <input type="text" class="form-control bg-light" id="ecart_display_caisse" readonly>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Mettre à jour
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
    const cahier    = document.querySelector('[name="montant_cahier"]');
    const caisse    = document.querySelector('[name="montant_caisse"]');
    const ecart     = document.getElementById('ecart_display_caisse');
    const ecartCahierWarehouse = document.getElementById('ecart_display');

    function updateEcart() {
        const diff = (parseInt(caisse.value) || 0) - (parseInt(warehouse.value) || 0);
        ecart.value = diff.toLocaleString('fr-FR');
        ecart.style.color = diff < 0 ? '#dc3545' : '#198754';
    }

        function updateEcartCahierWarehouse() {
            const diffCahierWarehouse = (parseInt(cahier.value) || 0) - (parseInt(warehouse.value) || 0);
            ecartCahierWarehouse.value = diffCahierWarehouse.toLocaleString('fr-FR');
            ecartCahierWarehouse.style.color = diffCahierWarehouse < 0 ? '#dc3545' : '#198754';
        }

    warehouse.addEventListener('input', updateEcart);
    caisse.addEventListener('input', updateEcart);
    cahier.addEventListener('input', updateEcartCahierWarehouse);
    warehouse.addEventListener('input', updateEcartCahierWarehouse);
    updateEcart();
    updateEcartCahierWarehouse();
</script>
@endpush
