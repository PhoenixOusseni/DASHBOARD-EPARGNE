@extends('layouts.app')
@section('title', 'Provinces')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('provinces.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle province
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <i class="bi bi-geo-alt me-2 text-primary"></i><strong>Liste des provinces</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Province</th>
                    <th>Région</th>
                    <th class="text-end" style="width:120px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($provinces as $province)
                <tr>
                    <td class="text-muted">{{ $province->id }}</td>
                    <td class="fw-semibold">{{ $province->nom }}</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $province->region->nom }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('provinces.edit', $province) }}" class="btn btn-sm btn-outline-primary btn-action me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('provinces.destroy', $province) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cette province ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucune province enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($provinces->hasPages())
    <div class="card-footer bg-white">{{ $provinces->links() }}</div>
    @endif
</div>
@endsection
