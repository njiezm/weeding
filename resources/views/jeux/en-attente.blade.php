@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card text-center p-5">
            <i class="fa-solid fa-hourglass-half fa-4x mb-4 text-warning"></i>
            <h2 class="mb-4">Jeu en attente</h2>
            <p class="lead">{{ $message }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fa-solid fa-home me-2"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</div>

@endsection