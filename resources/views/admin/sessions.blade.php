@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/"  class="h3 mb-4"><i class="fa-solid fa-gamepad me-2"></i> Gestion des sessions de jeu</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Créer une nouvelle session</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeSession') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la session</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="type_jeu" class="form-label">Type de jeu</label>
                            <select class="form-select" id="type_jeu" name="type_jeu" required>
                                <option value="">Sélectionner...</option>
                                <option value="qui_deux">Qui de nous deux ?</option>
                                <option value="chasse_photo">Chasse au trésor photo</option>
                                <option value="mots_croises">Mots croisés</option>
                                <option value="memory">Memory</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Créer la session
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
                    <h5 class="card-title mb-0">Liste des sessions</h5>
                </div>
                <div class="card-body">
                    @if($sessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                <tr>
                                    <td>{{ $session->nom }}</td>
                                    <td>{{ $session->description ?? '-' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $session->type_jeu)) }}</td>
                                    <td>
                                        @if($session->actif)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ $session->debut ? $session->debut->format('d/m/Y H:i') : '-' }}</td>
                                    <td>{{ $session->fin ? $session->fin->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $session->id }}">
                                                <i class="fa-solid fa-edit"></i> Modifier
                                            </button>
                                            
                                            @if($session->type_jeu === 'qui_deux')
                                                <a href="{{ route('admin.resultats', $session->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-chart-bar"></i> Résultats
                                                </a>
                                            @endif
                                            
                                            @if($session->type_jeu === 'chasse_photo')
                                                <a href="{{ route('admin.chassePhotosSubmissions', $session->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-images"></i> Voir les photos
                                                </a>
                                            @endif
                                            
                                            @if($session->type_jeu === 'mots_croises')
                                                <a href="{{ route('admin.editMotsCroises', $session->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-puzzle-piece"></i> Gérer les mots
                                                </a>
                                            @endif
                                            
                                            @if($session->type_jeu === 'memory')
                                                <a href="{{ route('admin.memoryCards') }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-brain"></i> Gérer les cartes
                                                </a>
                                            @endif
                                            
                                            @if($session->actif)
                                                <form action="{{ route('admin.arreterSession', $session->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-stop"></i> Arrêter
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.lancerSession', $session->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fa-solid fa-play"></i> Lancer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>Aucune session trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition -->
@foreach($sessions as $session)
<div class="modal fade" id="editModal{{ $session->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $session->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $session->id }}">Modifier la session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateSession', $session->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom_{{ $session->id }}" class="form-label">Nom de la session</label>
                        <input type="text" class="form-control" id="nom_{{ $session->id }}" name="nom" value="{{ $session->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description_{{ $session->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description_{{ $session->id }}" name="description" rows="3">{{ $session->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type_jeu_{{ $session->id }}" class="form-label">Type de jeu</label>
                        <select class="form-select" id="type_jeu_{{ $session->id }}" name="type_jeu" required>
                            <option value="qui_deux" {{ $session->type_jeu === 'qui_deux' ? 'selected' : '' }}>Qui de nous deux ?</option>
                            <option value="chasse_photo" {{ $session->type_jeu === 'chasse_photo' ? 'selected' : '' }}>Chasse au trésor photo</option>
                            <option value="mots_croises" {{ $session->type_jeu === 'mots_croises' ? 'selected' : '' }}>Mots croisés</option>
                            <option value="memory" {{ $session->type_jeu === 'memory' ? 'selected' : '' }}>Memory</option>
                            <option value="autre" {{ $session->type_jeu === 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
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