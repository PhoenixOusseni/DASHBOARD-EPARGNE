<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Épargne')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }

        .sidebar {
            min-height: 100vh;
            width: 240px;
            background: #1a2942;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding-top: 1rem;
        }

        .sidebar .brand {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 1rem 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: .6rem 1.25rem;
            border-radius: 6px;
            margin: 2px 8px;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            transition: all .2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.12);
        }

        .sidebar .nav-section {
            color: rgba(255,255,255,.35);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 1rem 1.25rem .3rem;
        }

        .main-content {
            margin-left: 240px;
            padding: 1.5rem;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e3e6ea;
            padding: .75rem 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h5 { margin: 0; font-weight: 600; color: #1a2942; }

        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.07); border-radius: 10px; }
        .card-header { border-radius: 10px 10px 0 0 !important; font-weight: 600; }

        .table thead th { background: #1a2942; color: #fff; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; border: none; }
        .table-region { background: #e8ecf3 !important; font-weight: 700; font-size: .85rem; }
        .table-total  { font-weight: 700; }

        .badge-mois { background: #e8f4fd; color: #0a6ebd; font-weight: 600; padding: .4rem .8rem; border-radius: 20px; font-size: .85rem; }

        .stat-card { border-radius: 12px; padding: 1.2rem 1.5rem; color: #fff; }
        .stat-card .stat-label { font-size: .78rem; opacity: .85; text-transform: uppercase; letter-spacing: .06em; }
        .stat-card .stat-value { font-size: 1.6rem; font-weight: 700; margin-top: .2rem; }

        .btn-action { padding: .25rem .5rem; font-size: .78rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<nav class="sidebar">
    <div class="brand">
        <i class="bi bi-bank2"></i>
        Dashboard Épargne
    </div>

    <div class="nav-section">Navigation</div>
    <a href="{{ route('dashboard.global') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line-fill"></i> Tableau de bord
    </a>

    <div class="nav-section">Saisie</div>
    <a href="{{ route('rapports.create') }}" class="nav-link {{ request()->routeIs('rapports.create') ? 'active' : '' }}">
        <i class="bi bi-pencil-square"></i> Saisir un rapport
    </a>
    <a href="{{ route('rapports.index') }}" class="nav-link {{ request()->routeIs('rapports.*') && !request()->routeIs('rapports.create') ? 'active' : '' }}">
        <i class="bi bi-table"></i> Liste des rapports
    </a>
    <a href="{{ route('montants-odk.index') }}" class="nav-link {{ request()->routeIs('montants-odk.*') ? 'active' : '' }}">
        <i class="bi bi-table"></i> Montant ODK
    </a>
    <div class="nav-section">Paramètres</div>
    <a href="{{ route('regions.index') }}" class="nav-link {{ request()->routeIs('regions.*') ? 'active' : '' }}">
        <i class="bi bi-map"></i> Régions
    </a>
    <a href="{{ route('provinces.index') }}" class="nav-link {{ request()->routeIs('provinces.*') ? 'active' : '' }}">
        <i class="bi bi-geo-alt"></i> Provinces
    </a>
</nav>

{{-- Main --}}
<div class="main-content">
    <div class="topbar">
        <h5>@yield('title', 'Dashboard Épargne')</h5>
        <span class="text-muted" style="font-size:.85rem">
            <i class="bi bi-calendar3"></i>
            {{ now()->translatedFormat('l d F Y') }}
        </span>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
