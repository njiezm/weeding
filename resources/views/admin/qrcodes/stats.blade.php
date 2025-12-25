// resources/views/admin/qrcodes/stats.blade.php
@extends('layout')

@section('content')
<div class="container">
    <h1>Statistiques pour : {{ $qrCode->name }}</h1>
    <p><strong>Source :</strong> {{ $qrCode->source }}</p>
    <p><strong>URL de destination :</strong> <a href="{{ $qrCode->destination_url }}" target="_blank">{{ $qrCode->destination_url }}</a></p>
    <p><strong>Nombre total de scans :</strong> {{ $qrCode->scans->count() }}</p>
    
    <hr>

    <h3>Détails des scans</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>IP</th>
                    <th>Localisation (IP)</th>
                    <th>Appareil (User-Agent)</th>
                    <th>Fingerprint ID</th>
                    <th>Résolution</th>
                    <th>GPS (Précis)</th>
                    <th>Permission GPS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scans as $scan)
                    <tr>
                        <td>{{ $scan->scanned_at->format('d/m H:i') }}</td>
                        <td>{{ $scan->ip_address }}</td>
                        <td>{{ $scan->location_data['city'] ?? 'N/A' }}</td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;" title="{{ $scan->user_agent }}">
                            {{ Str::limit($scan->user_agent, 40) }}
                        </td>
                        <td><code>{{ $scan->fingerprint_id ?? 'N/A' }}</code></td>
                        <td>{{ $scan->screen_resolution ?? 'N/A' }}</td>
                        <td>
                            @if($scan->precise_location)
                                <a href="https://www.google.com/maps?q={{ $scan->precise_location['lat'] }},{{ $scan->precise_location['lon'] }}" target="_blank">
                                    Voir (±{{ round($scan->precise_location['accuracy']) }}m)
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $scan->location_permission_status === 'granted' ? 'success' : ($scan->location_permission_status === 'denied' ? 'danger' : 'secondary') }}">
                                {{ $scan->location_permission_status ?? 'N/A' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Aucun scan enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $scans->links() }}
    
    <a href="{{ route('admin.qrcodes.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection