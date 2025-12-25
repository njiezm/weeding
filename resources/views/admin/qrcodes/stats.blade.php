@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/" class="h2">Statistiques pour : {{ $qrCode->name }}</h1>
        <a href="{{ route('admin.qrcodes.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $qrCode->scans->count() }}</h5>
                    <p class="card-text">Scans au total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $qrCode->scans()->whereNotNull('precise_location')->count() }}</h5>
                    <p class="card-text">Localisations GPS</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $qrCode->scans()->distinct('ip_address')->count('ip_address') }}</h5>
                    <p class="card-text">Visiteurs uniques (IP)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ round(($qrCode->scans()->where('location_permission_status', 'granted')->count() / max($qrCode->scans->count(), 1)) * 100) }}%</h5>
                    <p class="card-text">Taux de permission GPS</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-list me-2"></i>Détails des scans</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>IP</th>
                            <th>Localisation (IP)</th>
                            <th>Appareil (Navigateur / OS)</th>
                            <th>Fingerprint</th>
                            <th>GPS</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scans as $scan)
                            <tr>
                                <td>{{ $scan->scanned_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $scan->ip_address }}</td>
                                <td>{{ $scan->location_data['city'] ?? 'N/A' }}</td>
                                <td title="{{ $scan->user_agent }}">
                                    @php
                                        $ua = $scan->user_agent;
                                        $browser = "Inconnu";
                                        if (preg_match('/Chrome/i', $ua)) $browser = "Chrome";
                                        elseif (preg_match('/Firefox/i', $ua)) $browser = "Firefox";
                                        elseif (preg_match('/Safari/i', $ua)) $browser = "Safari";
                                        elseif (preg_match('/Edg/i', $ua)) $browser = "Edge";
                                        
                                        $os = "Inconnu";
                                        if (preg_match('/Windows/i', $ua)) $os = "Windows";
                                        elseif (preg_match('/Mac/i', $ua)) $os = "macOS";
                                        elseif (preg_match('/Linux/i', $ua)) $os = "Linux";
                                        elseif (preg_match('/Android/i', $ua)) $os = "Android";
                                        elseif (preg_match('/iOS/i', $ua)) $os = "iOS";
                                    @endphp
                                    <span class="fw-bold">{{ $browser }}</span> / {{ $os }}
                                </td>
                                <td>
                                <code style="font-size:0.8em;">
                                    {{ \Illuminate\Support\Str::limit($scan->fingerprint_id ?? 'N/A', 20) }}
                                </code>
                            </td>

                                <td>
                                    @if($scan->precise_location)
                                        <a href="https://www.google.com/maps?q={{ $scan->precise_location['lat'] }},{{ $scan->precise_location['lon'] }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fa-solid fa-map-marker-alt"></i> Voir
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($scan->client_logs)
                                        <a href="{{ route('admin.qrcodes.downloadLogs', $scan->id) }}" class="btn btn-sm btn-outline-info" title="Télécharger les logs détaillés">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted" title="Pas de logs disponibles">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun scan enregistré pour ce QR Code.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $scans->links() }}
        </div>
    </div>
</div>
@endsection