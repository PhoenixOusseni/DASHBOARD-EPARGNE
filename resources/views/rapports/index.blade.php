@extends('layouts.app')
@section('title', 'Rapports d\'épargnes')
@section('content')

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('rapports.index') }}" class="row g-3 align-items-end">
            <div class="col-auto">
                <label class="form-label fw-semibold">Mois</label>
                <select name="mois" class="form-select">
                    @foreach([1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
                               7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre']
                              as $n => $nom)
                        <option value="{{ $n }}" @selected($n == $mois)>{{ $nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label fw-semibold">Année</label>
                <select name="annee" class="form-select">
                    @foreach($annees as $a)
                        <option value="{{ $a }}" @selected($a == $annee)>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filtrer</button>
                <a href="{{ route('rapports.create') }}" class="btn btn-success btn-sm ms-2">
                    <i class="bi bi-plus-lg me-1"></i>Nouveau rapport
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <i class="bi bi-table me-2 text-primary"></i>
        <strong>Rapports – {{ [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
                               7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'][$mois] }}
            {{ $annee }}</strong>
        <span class="text-muted ms-2">({{ $rapports->total() }} rapport(s))</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0" style="font-size:.88rem">
            <thead>
                <tr>
                    <th>Province</th>
                    <th>Région</th>
                    <th class="text-end">Warehouse</th>
                    <th class="text-end">Cahier</th>
                    <th class="text-end">Caisse</th>
                    <th class="text-end">Écart Cahier</th>
                    <th class="text-end">Écart Caisse</th>
                    <th class="text-end">G50</th>
                    <th class="text-end" style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rapports as $rapport)
                <tr>
                    <td class="fw-semibold">{{ $rapport->province->nom }}</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $rapport->province->region->nom }}</span></td>
                    <td class="text-end">{{ number_format($rapport->montant_warehouse, 0, ',', ' ') }}</td>
                    <td class="text-end">{{ number_format($rapport->montant_cahier, 0, ',', ' ') }}</td>
                    <td class="text-end">{{ number_format($rapport->montant_caisse, 0, ',', ' ') }}</td>
                    <td class="text-end {{ $rapport->ecart < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($rapport->ecart, 0, ',', ' ') }}
                    </td>
                    <td class="text-end {{ $rapport->ecart_caisse_warehouse < 0 ? 'text-danger' : 'text-success' }}">
                        <span class="badge {{ $rapport->ecart_caisse_warehouse < 0 ? 'bg-danger bg-opacity-10 text-danger' : 'bg-success bg-opacity-10 text-success' }}">
                            {{ number_format($rapport->ecart_caisse_warehouse, 0, ',', ' ') }}
                        </span>
                    </td>
                    <td class="text-end">{{ $rapport->rapports_g50 }}</td>
                    <td class="text-end">
                        <a href="{{ route('rapports.edit', $rapport) }}" class="btn btn-sm btn-outline-primary btn-action me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('rapports.destroy', $rapport) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer ce rapport ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun rapport pour ce mois/année.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rapports->hasPages())
    <div class="card-footer bg-white">{{ $rapports->links() }}</div>
    @endif
</div>
@endsection
