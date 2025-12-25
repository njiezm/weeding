@extends('layout') 

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/" class="h2">Gestion des QR Codes</h1>
        <a href="{{ route('admin.qrcodes.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrows-rotate me-1"></i> Actualiser
        </a>
    </div>

    <!-- Formulaire de création -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-qrcode me-2"></i>Créer un nouveau QR Code</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.qrcodes.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="name" class="form-label">Nom du QR Code</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: Table 1, Entrée Principale, Livre d'or" required>
                        <div class="form-text">Un nom clair pour vous identifier.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="source" class="form-label">Source / Emplacement</label>
                        <input type="text" class="form-control" id="source" name="source" placeholder="ex: Table, WhatsApp, Église..." required>
                        <div class="form-text">Où ce QR code sera placé ?</div>
                    </div>
                    <div class="col-md-3">
                        <label for="destination_url" class="form-label">URL de Destination</label>
                        <input type="url" class="form-control" id="destination_url" name="destination_url" value="https://gilles-et-maeva.njiezm.fr/" readonly>
                        <div class="form-text">L'URL est prédéfinie.</div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Générer le QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des QR Codes existants -->
<h3 class="h4 mb-3">QR Codes existants</h3>
<div class="row">
    @forelse($qrCodes as $qrCode)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong title="{{ $qrCode->name }}">{{ str($qrCode->name)->limit(25) }}</strong>
                    <span class="badge bg-secondary">{{ $qrCode->source }}</span>
                </div>
                <div class="card-body d-flex flex-column">
                   <div class="text-center mb-3 position-relative">
    <div class="qr-code-container">
        {!! QrCode::size(250)->errorCorrection('H')->color(0, 100, 0)->generate(route('qr.track', $qrCode->uuid)) !!}
        <div class="qr-logo-overlay">
            <img src="{{ asset('images/logo-metg.png') }}" alt="Logo" class="qr-logo">
        </div>
    </div>
</div>
                    <p class="small text-muted mb-2">URL de suivi : <br><code>{{ route('qr.track', $qrCode->uuid) }}</code></p>
                    
                    <div class="mt-auto">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('admin.qrcodes.stats', $qrCode->id) }}" class="btn btn-info btn-sm">
                                <i class="fa-solid fa-chart-line me-1"></i> Stats ({{ $qrCode->scans->count() }})
                            </a>
                            <a href="{{ route('admin.qrcodes.download', $qrCode->id) }}" class="btn btn-success btn-sm" title="Télécharger le QR Code">
    <i class="fa-solid fa-download"></i>
</a>
                            <button onclick="copyToClipboard('{{ route('qr.track', $qrCode->uuid) }}')" class="btn btn-outline-secondary btn-sm" title="Copier l'URL de suivi">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-qrcode fa-3x mb-3"></i>
                <h4>Aucun QR Code pour le moment</h4>
                <p>Utilisez le formulaire ci-dessus pour générer votre premier QR Code et commencer à suivre les interactions.</p>
            </div>
        </div>
    @endforelse
</div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Afficher une notification ou un message de confirmation
        alert('URL copiée dans le presse-papiers !');
    }, function(err) {
        console.error('Échec de la copie: ', err);
    });
}
</script>
@endsection