@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4"><i class="fa-solid fa-calendar-days me-2"></i> Gestion des Étapes de la Cérémonie</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter une nouvelle étape</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeEtapeCeremonie') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre de l'étape</label>
                                <input type="text" class="form-control" id="titre" name="titre" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="icone" class="form-label">Icône (Font Awesome)</label>
                                <input type="text" class="form-control" id="icone" name="icone" placeholder="fa-solid fa-music">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ordre" class="form-label">Ordre</label>
                                <input type="number" class="form-control" id="ordre" name="ordre" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter l'étape
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
                    <h5 class="card-title mb-0">Liste des étapes</h5>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Retour au tableau de bord
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($etapes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ordre</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Icône</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etapes as $etape)
                                <tr>
                                    <td>{{ $etape->ordre }}</td>
                                    <td>{{ $etape->titre }}</td>
                                    <td>{{ Str::limit($etape->description, 100) }}</td>
                                    <td>
                                        @if($etape->icone)
                                            <i class="{{ $etape->icone }}"></i>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($etape->en_cours)
                                            <span class="badge bg-primary">En cours</span>
                                        @elseif($etape->termine)
                                            <span class="badge bg-success">Terminé</span>
                                        @else
                                            <span class="badge bg-secondary">À venir</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $etape->id }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            
                                            @if(!$etape->en_cours)
                                                <form action="{{ route('admin.marquerEnCours', $etape->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-info">
                                                        <i class="fa-solid fa-play"></i> En cours
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($etape->termine)
                                                <form action="{{ route('admin.marquerNonTermine', $etape->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="fa-solid fa-undo"></i> Réouvrir
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.marquerTermine', $etape->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fa-solid fa-check"></i> Terminer
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.deleteEtapeCeremonie', $etape->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette étape ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>Aucune étape trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition -->
@foreach($etapes as $etape)
<div class="modal fade" id="editModal{{ $etape->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $etape->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $etape->id }}">Modifier l'étape</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateEtapeCeremonie', $etape->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titre_{{ $etape->id }}" class="form-label">Titre de l'étape</label>
                        <input type="text" class="form-control" id="titre_{{ $etape->id }}" name="titre" value="{{ $etape->titre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="icone_{{ $etape->id }}" class="form-label">Icône (Font Awesome)</label>
                        <input type="text" class="form-control" id="icone_{{ $etape->id }}" name="icone" value="{{ $etape->icone }}">
                    </div>
                    <div class="mb-3">
                        <label for="ordre_{{ $etape->id }}" class="form-label">Ordre</label>
                        <input type="number" class="form-control" id="ordre_{{ $etape->id }}" name="ordre" value="{{ $etape->ordre }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="description_{{ $etape->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description_{{ $etape->id }}" name="description" rows="3">{{ $etape->description }}</textarea>
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