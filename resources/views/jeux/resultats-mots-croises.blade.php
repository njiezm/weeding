@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fa-solid fa-puzzle-piece me-2"></i> Résultats - Mots Croisés</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>Score : {{ $score }}/{{ $total }}</h2>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%;" aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">{{ $pourcentage }}%</div>
                    </div>
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