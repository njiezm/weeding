@extends('layout')
@section('content')

<div class="container-fluid dashboard-container">
    <div class="row">
        <div class="col-12">
            <h1 style="color:#e8e8e8; /*var(--vert-sapin);*/"  class="h3 mb-4"><i class="fa-solid fa-gauge-high me-2"></i> Tableau de bord</h1>
        </div>
    </div>
    
    <!-- Indicateurs clés -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card stats-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-label">Sessions actives</h6>
                            <h3 class="stats-value">{{ $sessions->where('actif', true)->count() }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card stats-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-label">Questions actives</h6>
                            <h3 class="stats-value">{{ $questionsActives }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-question-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card stats-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-label">Étapes en cours</h6>
                            <h3 class="stats-value">{{ $etapesEnCours }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card stats-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-label">Participants</h6>
                            <h3 class="stats-value">{{ $participantsCount }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modules principaux -->
    <div class="row">
        <!-- Sessions de jeu -->
        <div class="col-lg-8 mb-4">
            <div class="card dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-gamepad me-2"></i> Sessions de jeu</h5>
                    <a href="{{ route('admin.sessions') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($sessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions->take(5) as $session)
                                <tr>
                                    <td>{{ $session->nom }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $session->type_jeu)) }}</td>
                                    <td>
                                        @if($session->actif)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.resultats', $session->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-chart-bar"></i> Résultats
                                            </a>
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
                    <div class="empty-state text-center py-4">
                        <i class="fa-solid fa-gamepad fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune session de jeu trouvée.</p>
                        <a href="{{ route('admin.sessions') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Créer une session
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Étapes de la cérémonie -->
        <div class="col-lg-4 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-calendar-days me-2"></i> Étapes de la cérémonie</h5>
                    <a href="{{ route('admin.etapesCeremonie') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                </div>
                <div class="card-body">
                    @if($etapesCeremonie->count() > 0)
                    <div class="timeline-steps">
                        @foreach($etapesCeremonie->take(5) as $etape)
                        <div class="step-item @if($etape->en_cours) active @elseif($etape->termine) completed @endif">
                            <div class="step-marker">
                                @if($etape->en_cours)
                                    <i class="fa-solid fa-play"></i>
                                @elseif($etape->termine)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <i class="fa-solid fa-clock"></i>
                                @endif
                            </div>

                            <div class="step-content">
                                <h6>{{ $etape->titre }}</h6>
                                <p class="small text-muted">{{ \Illuminate\Support\Str::limit($etape->description, 80) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state text-center py-4">
                        <i class="fa-solid fa-calendar-days fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune étape de cérémonie configurée.</p>
                        <a href="{{ route('admin.etapesCeremonie') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Configurer les étapes
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modules secondaires -->
    <div class="row">
        <!-- Questions "Qui de nous deux ?" -->
        <div class="col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-question-circle me-2"></i> Questions "Qui de nous deux ?"</h5>
                    <a href="{{ route('admin.questions') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                </div>
                <div class="card-body">
                    @if($questions->count() > 0)
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($questionsActives / $questions->count()) * 100 }}%" aria-valuenow="{{ $questionsActives }}" aria-valuemin="0" aria-valuemax="{{ $questions->count() }}">
                                    {{ $questionsActives }} / {{ $questions->count() }} actives
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questions->take(5) as $question)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Str::limit($question->question, 50) }}</td>
                                            <td>
                                                @if($question->active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="empty-state text-center py-4">
                        <i class="fa-solid fa-question-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune question trouvée.</p>
                        <a href="{{ route('admin.questions') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter des questions
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Mots croisés et Memory -->
        <div class="col-lg-6 mb-4">
            <div class="row h-100">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card dashboard-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fa-solid fa-puzzle-piece me-2"></i> Mots Croisés</h5>
                            <a href="{{ route('admin.motsCroises') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            @if($motsCroisesCount > 0)
                                <div class="text-center">
                                    <h3 class="mb-2">{{ $motsCroisesCount }}</h3>
                                    <p class="text-muted">grilles configurées</p>
                                </div>
                            @else
                                <div class="empty-state text-center">
                                    <i class="fa-solid fa-puzzle-piece fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune grille configurée.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card dashboard-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fa-solid fa-brain me-2"></i> Memory</h5>
                            <a href="{{ route('admin.memoryCards') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            @if($memoryCardsCount > 0)
                                <div class="text-center">
                                    <h3 class="mb-2">{{ $memoryCardsCount }}</h3>
                                    <p class="text-muted">paires de cartes</p>
                                </div>
                            @else
                                <div class="empty-state text-center">
                                    <i class="fa-solid fa-brain fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune carte configurée.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

