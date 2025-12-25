@extends('layout') 

@section('content')
<div class="container">
    <h1>Gestion des QR Codes</h1>

    <!-- Formulaire de création -->
    <div class="card mb-4">
        <div class="card-header">Créer un nouveau QR Code</div>
        <div class="card-body">
            <form action="{{ route('admin.qrcodes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: Table 1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="source" class="form-label">Source</label>
                        <!-- J'ai remis le select comme dans la proposition initiale, c'est mieux pour la cohérence -->
                        <select class="form-select" id="source" name="source" required>
                            <option value="tableau">Tableau</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="entree">Entrée</option>
                            <option value="eglise">Église</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="destination_url" class="form-label">URL de Destination</label>
                        <input type="url" class="form-control" id="destination_url" name="destination_url" placeholder="https://votresite.com/" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Générer le QR Code</button>
            </form>
        </div>
    </div>

    <!-- Liste des QR Codes existants -->
    <div class="row">
        @forelse($qrCodes as $qrCode)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>{{ $qrCode->name }}</strong>
                        <span class="badge bg-secondary">{{ $qrCode->source }}</span>
                    </div>
                    <div class="card-body text-center">
                        <p>URL de suivi : <br><small>{{ route('qr.track', $qrCode->uuid) }}</small></p>
                        <div class="mb-3">
                            {!! QrCode::size(200)->generate(route('qr.track', $qrCode->uuid)) !!}
                        </div>
                        <a href="{{ route('admin.qrcodes.stats', $qrCode->id) }}" class="btn btn-info btn-sm">Voir les stats ({{ $qrCode->scans->count() }} scans)</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fa-solid fa-qrcode fa-3x mb-3"></i>
                    <h4>Aucun QR Code pour le moment</h4>
                    <p>Utilisez le formulaire ci-dessus pour générer votre premier QR Code.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection