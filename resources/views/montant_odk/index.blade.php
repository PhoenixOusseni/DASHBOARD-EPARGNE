@extends('layouts.app')
@section('title', 'Montants ODK')
@section('content')

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('montants-odk.index') }}" class="row g-3 align-items-end">
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
                <a href="{{ route('montants-odk.create') }}" class="btn btn-success btn-sm ms-2">
                    <i class="bi bi-plus-lg me-1"></i>Nouveau montant
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <i class="bi bi-calculator me-2 text-primary"></i>
        <strong>Montants ODK – {{ [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
                               7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'][$mois] }}
            {{ $annee }}</strong>
        <span class="text-muted ms-2">({{ $montants->total() }} montant(s))</span>
    </div>
    <div class="card-body p-2">
        <table class="table table-hover mb-0" style="font-size:.88rem">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Mois</th>
                    <th>Année</th>
                    <th class="text-end">Montant ODK (FCFA)</th>
                    <th class="text-end" style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($montants as $montant)
                <tr>
                    <td class="text-muted">{{ $montant->id }}</td>
                    <td class="">{{ [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
                               7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'][$montant->mois] }}</td>
                    <td class="">{{ $montant->annee }}</td>
                    <td class="text-end fw-semibold">{{ number_format($montant->montant_odk, 0, ',', ' ') }}</td>
                    <td class="text-end">
                        <a href="{{ route('montants-odk.edit', $montant) }}" class="btn btn-sm btn-outline-primary btn-action me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('montants-odk.destroy', $montant) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer ce montant ODK ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Aucun montant ODK pour ce mois/année.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($montants->hasPages())
    <div class="card-footer bg-white">{{ $montants->links() }}</div>
    @endif
</div>
@endsection
