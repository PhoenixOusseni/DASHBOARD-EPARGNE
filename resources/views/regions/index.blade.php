@extends('layouts.app')
@section('title', 'Régions')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('regions.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle région
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <i class="bi bi-map me-2 text-primary"></i><strong>Liste des régions</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom de la région</th>
                    <th class="text-center">Nb. Provinces</th>
                    <th class="text-end" style="width:120px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regions as $region)
                <tr>
                    <td class="text-muted">{{ $region->id }}</td>
                    <td class="fw-semibold">{{ $region->nom }}</td>
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ $region->provinces_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('regions.edit', $region) }}" class="btn btn-sm btn-outline-primary btn-action me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('regions.destroy', $region) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cette région ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucune région enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($regions->hasPages())
    <div class="card-footer bg-white">{{ $regions->links() }}</div>
    @endif
</div>
@endsection
