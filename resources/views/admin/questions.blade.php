@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4"><i class="fa-solid fa-question-circle me-2"></i> Gestion des questions</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter une nouvelle question</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeQuestion') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="bonne_reponse" class="form-label">Bonne réponse</label>
                            <select class="form-select" id="bonne_reponse" name="bonne_reponse" required>
                                <option value="">Sélectionner...</option>
                                <option value="Gilles">Gilles</option>
                                <option value="Maëva">Maëva</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter la question
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
                    <h5 class="card-title mb-0">Liste des questions</h5>
                </div>
                <div class="card-body">
                    @if($questions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Bonne réponse</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ $question->question }}</td>
                                    <td>{{ $question->bonne_reponse }}</td>
                                    <td>
                                        @if($question->active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $question->id }}">
                                                <i class="fa-solid fa-edit"></i> Modifier
                                            </button>
                                            <form action="{{ route('admin.deleteQuestion', $question->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i> Supprimer
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
                    <p>Aucune question trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition -->
@foreach($questions as $question)
<div class="modal fade" id="editModal{{ $question->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $question->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $question->id }}">Modifier la question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateQuestion', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question_{{ $question->id }}" class="form-label">Question</label>
                        <textarea class="form-control" id="question_{{ $question->id }}" name="question" rows="3" required>{{ $question->question }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bonne_reponse_{{ $question->id }}" class="form-label">Bonne réponse</label>
                        <select class="form-select" id="bonne_reponse_{{ $question->id }}" name="bonne_reponse" required>
                            <option value="Gilles" {{ $question->bonne_reponse === 'Gilles' ? 'selected' : '' }}>Gilles</option>
                            <option value="Maëva" {{ $question->bonne_reponse === 'Maëva' ? 'selected' : '' }}>Maëva</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="active_{{ $question->id }}" name="active" {{ $question->active ? 'checked' : '' }}>
                        <label class="form-check-label" for="active_{{ $question->id }}">Question active</label>
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