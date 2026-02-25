@extends('layouts.app')
@section('title', 'Modifier la province')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <i class="bi bi-geo-alt me-2 text-primary"></i><strong>Modifier la province</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('provinces.update', $province) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Région <span class="text-danger">*</span></label>
                        <select name="region_id" class="form-select @error('region_id') is-invalid @enderror">
                            <option value="">-- Sélectionner une région --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" @selected(old('region_id', $province->region_id) == $region->id)>
                                    {{ $region->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('region_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom de la province <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                               value="{{ old('nom', $province->nom) }}">
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
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
