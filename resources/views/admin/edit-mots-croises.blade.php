@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/"  class="h3 mb-4"><i class="fa-solid fa-puzzle-piece me-2"></i> Modifier la grille : {{ $motsCroises->titre }}</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations de la grille</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateMotsCroises', $motsCroises->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="{{ $motsCroises->titre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="taille" class="form-label">Taille de la grille</label>
                            <input type="number" class="form-control" id="taille" name="taille" value="{{ $motsCroises->taille }}" min="5" max="20" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $motsCroises->description }}</textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="actif" name="actif" {{ $motsCroises->actif ? 'checked' : '' }}>
                            <label class="form-check-label" for="actif">Grille active</label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-2"></i> Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter un mot</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeMot', $motsCroises->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="mot" class="form-label">Mot</label>
                            <input type="text" class="form-control" id="mot" name="mot" required>
                        </div>
                        <div class="mb-3">
                            <label for="definition" class="form-label">Définition</label>
                            <textarea class="form-control" id="definition" name="definition" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="position_x" class="form-label">Position X</label>
                                <input type="number" class="form-control" id="position_x" name="position_x" min="0" max="{{ $motsCroises->taille - 1 }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="position_y" class="form-label">Position Y</label>
                                <input type="number" class="form-control" id="position_y" name="position_y" min="0" max="{{ $motsCroises->taille - 1 }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="direction" class="form-label">Direction</label>
                                <select class="form-select" id="direction" name="direction" required>
                                    <option value="horizontal">Horizontal</option>
                                    <option value="vertical">Vertical</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter le mot
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des mots</h5>
                </div>
                <div class="card-body">
                    @if($motsCroises->mots->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mot</th>
                                    <th>Définition</th>
                                    <th>Position</th>
                                    <th>Direction</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motsCroises->mots as $mot)
                                <tr>
                                    <td>{{ $mot->mot }}</td>
                                    <td>{{ Str::limit($mot->definition, 100) }}</td>
                                    <td>({{ $mot->position_x }}, {{ $mot->position_y }})</td>
                                    <td>{{ $mot->direction === 'horizontal' ? 'Horizontal' : 'Vertical' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $mot->id }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.deleteMot', $mot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mot ?')">
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
                    <p>Aucun mot ajouté à cette grille.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition -->
@foreach($motsCroises->mots as $mot)
<div class="modal fade" id="editModal{{ $mot->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $mot->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $mot->id }}">Modifier le mot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateMot', $mot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mot_{{ $mot->id }}" class="form-label">Mot</label>
                        <input type="text" class="form-control" id="mot_{{ $mot->id }}" name="mot" value="{{ $mot->mot }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="definition_{{ $mot->id }}" class="form-label">Définition</label>
                        <textarea class="form-control" id="definition_{{ $mot->id }}" name="definition" rows="3" required>{{ $mot->definition }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="position_x_{{ $mot->id }}" class="form-label">Position X</label>
                            <input type="number" class="form-control" id="position_x_{{ $mot->id }}" name="position_x" value="{{ $mot->position_x }}" min="0" max="{{ $motsCroises->taille - 1 }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="position_y_{{ $mot->id }}" class="form-label">Position Y</label>
                            <input type="number" class="form-control" id="position_y_{{ $mot->id }}" name="position_y" value="{{ $mot->position_y }}" min="0" max="{{ $motsCroises->taille - 1 }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="direction_{{ $mot->id }}" class="form-label">Direction</label>
                            <select class="form-select" id="direction_{{ $mot->id }}" name="direction" required>
                                <option value="horizontal" {{ $mot->direction === 'horizontal' ? 'selected' : '' }}>Horizontal</option>
                                <option value="vertical" {{ $mot->direction === 'vertical' ? 'selected' : '' }}>Vertical</option>
                            </select>
                        </div>
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