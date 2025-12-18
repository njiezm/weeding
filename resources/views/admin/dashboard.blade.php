@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4"><i class="fa-solid fa-gauge-high me-2"></i> Tableau de bord</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-gamepad me-2"></i> Sessions de jeu</h5>
                </div>
                <div class="card-body">
                    @if($sessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
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
                    <p>Aucune session de jeu trouvée.</p>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.sessions') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Gérer les sessions
                        </a>
                    </div>

                    
                </div>
            </div>
        </div>

         <div class="col-md-6 mg-bottom-20">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fa-solid fa-calendar-days me-2"></i> Étapes de la cérémonie</h5>
        </div>
        <div class="card-body">
            <p>Gérez les étapes de la cérémonie et suivez leur déroulement en direct.</p>
            <div class="mt-3">
                <a href="{{ route('admin.etapesCeremonie') }}" class="btn btn-primary">
                    <i class="fa-solid fa-calendar-days me-2"></i> Gérer les étapes
                </a>
            </div>
        </div>
    </div>
</div>
        
            <!-- Ajoutez ces blocs après les blocs existants -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fa-solid fa-puzzle-piece me-2"></i> Mots Croisés</h5>
        </div>
        <div class="card-body">
            <p>Gérez les grilles de mots croisés sur le thème des mariés.</p>
            <div class="mt-3">
                <a href="{{ route('admin.motsCroises') }}" class="btn btn-primary">
                    <i class="fa-solid fa-puzzle-piece me-2"></i> Gérer les mots croisés
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fa-solid fa-brain me-2"></i> Memory</h5>
        </div>
        <div class="card-body">
            <p>Gérez les cartes pour le jeu de memory avec les photos des mariés.</p>
            <div class="mt-3">
                <a href="{{ route('admin.memoryCards') }}" class="btn btn-primary">
                    <i class="fa-solid fa-brain me-2"></i> Gérer les cartes memory
                </a>
            </div>
        </div>
    </div>
</div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-question-circle me-2"></i> Questions "Qui de nous deux ?"</h5>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ Str::limit($question->question, 50) }}</td>
                                    <td>{{ $question->bonne_reponse }}</td>
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
                    @else
                    <p>Aucune question trouvée.</p>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.questions') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Gérer les questions
                        </a>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

</div>

@endsection