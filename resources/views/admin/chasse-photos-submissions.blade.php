@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4"><i class="fa-solid fa-camera me-2"></i> Soumissions - Chasse au Trésor Photo</h1>
            <h4 class="h5 mb-4 text-muted">Session : {{ $session->nom }}</h4>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($submissions->count() > 0)
                        <div class="row">
                            @foreach($submissions as $submission)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <a href="{{ $submission->photo_url }}" target="_blank">
                                            <img src="{{ $submission->photo_url }}" class="card-img-top" alt="Photo soumise" style="max-height: 200px; object-fit: cover;">
                                        </a>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $submission->participant->prenom }} {{ $submission->participant->nom }}</h6>
                                            <p class="card-text"><small class="text-muted">Indice : {{ $submission->indice }}</small></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge {{ $submission->valide ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $submission->valide ? 'Validée' : 'En attente' }}
                                                </span>
                                                <form action="{{ route('admin.validateChassePhoto', $submission->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $submission->valide ? 'btn-secondary' : 'btn-success' }}">
                                                        {{ $submission->valide ? 'Invalider' : 'Valider' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Aucune photo soumise pour cette session pour le moment.</p>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.sessions') }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i> Retour aux sessions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection