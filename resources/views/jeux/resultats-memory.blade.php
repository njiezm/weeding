@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fa-solid fa-brain me-2"></i> Résultats - Memory</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>Félicitations !</h2>
                    <p>Vous avez terminé le jeu en <strong>{{ $coups }}</strong> coups et en <strong>{{ gmdate('i:s', $temps) }}</strong> !</p>
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