@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fa-solid fa-trophy me-2"></i> Vos résultats</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>Score : {{ $score }}/{{ $total }}</h2>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%;" aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">{{ $pourcentage }}%</div>
                    </div>
                </div>
                
                <h4>Détail de vos réponses :</h4>
                <div class="list-group">
                    @foreach($reponses as $reponse)
                    <div class="list-group-item {{ $reponse->correct ? 'list-group-item-success' : 'list-group-item-danger' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $reponse->question->question }}</h5>
                            <span>
                                @if($reponse->correct)
                                    <i class="fa-solid fa-check-circle text-success"></i> Correct
                                @else
                                    <i class="fa-solid fa-times-circle text-danger"></i> Incorrect
                                @endif
                            </span>
                        </div>
                        <p class="mb-1">Votre réponse : {{ $reponse->reponse }}</p>
                        @if(!$reponse->correct)
                            <p class="mb-1">Bonne réponse : {{ $reponse->question->bonne_reponse }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fa-solid fa-home me-2"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection