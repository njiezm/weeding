@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/"  class="h3 mb-4"><i class="fa-solid fa-puzzle-piece me-2"></i> Gestion des Mots Croisés</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Créer une nouvelle grille de mots croisés</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeMotsCroises') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="titre" name="titre" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="taille" class="form-label">Taille de la grille</label>
                                <input type="number" class="form-control" id="taille" name="taille" min="5" max="20" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Créer la grille
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
                    <h5 class="card-title mb-0">Liste des grilles</h5>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Retour au tableau de bord
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($motsCroises->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Taille</th>
                                    <th>Nombre de mots</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motsCroises as $motsCroise)
                                <tr>
                                    <td>{{ $motsCroise->titre }}</td>
                                    <td>{{ $motsCroise->taille }}x{{ $motsCroise->taille }}</td>
                                    <td>{{ $motsCroise->mots->count() }}</td>
                                    <td>
                                        @if($motsCroise->actif)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.editMotsCroises', $motsCroise->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-edit"></i> Modifier
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>Aucune grille de mots croisés trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection