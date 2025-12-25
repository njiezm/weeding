@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/"  class="h3 mb-4"><i class="fa-solid fa-brain me-2"></i> Gestion des Cartes Memory</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter une nouvelle paire de cartes</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeMemoryCard') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre de la carte</label>
                                <input type="text" class="form-control" id="titre" name="titre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pair_id" class="form-label">ID de la paire</label>
                                <input type="text" class="form-control" id="pair_id" name="pair_id" required>
                                <small class="form-text text-muted">Utilisez le même ID pour les deux cartes d'une paire.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter la carte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Liste des cartes</h5>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Retour au tableau de bord
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($cards->count() > 0)
                    <div class="row">
                        @foreach($cards as $card)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset($card->image_url) }}" class="card-img-top" alt="{{ $card->titre }}" style="max-height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $card->titre }}</h6>
                                    <p class="card-text"><small class="text-muted">Paire : {{ $card->pair_id }}</small></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge {{ $card->actif ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $card->actif ? 'Active' : 'Inactive' }}
                                        </span>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $card->id }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.deleteMemoryCard', $card->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette carte ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>Aucune carte trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition -->
@foreach($cards as $card)
<div class="modal fade" id="editModal{{ $card->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $card->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $card->id }}">Modifier la carte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateMemoryCard', $card->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titre_{{ $card->id }}" class="form-label">Titre de la carte</label>
                        <input type="text" class="form-control" id="titre_{{ $card->id }}" name="titre" value="{{ $card->titre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="pair_id_{{ $card->id }}" class="form-label">ID de la paire</label>
                        <input type="text" class="form-control" id="pair_id_{{ $card->id }}" name="pair_id" value="{{ $card->pair_id }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description_{{ $card->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description_{{ $card->id }}" name="description" rows="3">{{ $card->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_{{ $card->id }}" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image_{{ $card->id }}" name="image" accept="image/*">
                        <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle.</small>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="actif_{{ $card->id }}" name="actif" {{ $card->actif ? 'checked' : '' }}>
                        <label class="form-check-label" for="actif_{{ $card->id }}">Carte active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection