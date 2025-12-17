@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4"><i class="fa-solid fa-chart-bar me-2"></i> Résultats de la session : {{ $session->nom }}</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Classement</h5>
                </div>
                <div class="card-body">
                    @if(count($scores) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rang</th>
                                    <th>Participant</th>
                                    <th>Score</th>
                                    <th>Total</th>
                                    <th>Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scores as $index => $score)
                                <tr>
                                    <td>
                                        @if($index === 0)
                                            <i class="fa-solid fa-trophy text-warning"></i> 1er
                                        @elseif($index === 1)
                                            <i class="fa-solid fa-medal text-secondary"></i> 2ème
                                        @elseif($index === 2)
                                            <i class="fa-solid fa-medal text-warning-50"></i> 3ème
                                        @else
                                            {{ $index + 1 }}ème
                                        @endif
                                    </td>
                                    <td>{{ $score['participant']->prenom }} {{ $score['participant']->nom }}</td>
                                    <td>{{ $score['score'] }}</td>
                                    <td>{{ $score['total'] }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar {{ $score['pourcentage'] >= 80 ? 'bg-success' : ($score['pourcentage'] >= 50 ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width: {{ $score['pourcentage'] }}%;" aria-valuenow="{{ $score['pourcentage'] }}" aria-valuemin="0" aria-valuemax="100">{{ $score['pourcentage'] }}%</div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>Aucun résultat trouvé pour cette session.</p>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Retour au tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection