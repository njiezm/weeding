@extends('layout')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
            <header class="mb-5">
                <h1 style="color:#e8e8e8 !important; /*var(--vert-sapin);*/" class="display-4 fw-bold text-muted">Une Pensée Pour...</h1>
                <p style="color:#e8e8e8; /*var(--vert-sapin);*/" class="lead">
                    En souvenir de ceux qui nous ont quittés, mais qui resteront pour toujours dans nos cœurs. 
                    Leur amour et leur mémoire continuent de nous guider.
                </p>
                <div class="separator"></div>
            </header>
        </div>
    </div>

    <div class="row g-4">
        @foreach($decedents as $person)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <!-- L'image avec un filtre pour un ton plus doux -->
                <div class="card-img-container">
                    <img src="{{ asset($person->photo) }}" class="card-img-top" alt="Photo de {{ $person->name }}">
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $person->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ $person->dates }}</p>
                    <p class="card-text small fst-italic">{{ $person->message }}</p>
                    <div class="mt-auto">
                        <span class="fs-2">🕯️</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    /* Styles personnalisés pour cette page */
    .card-img-container {
        height: 250px; /* Hauteur fixe pour toutes les images */
        overflow: hidden;
        background-color: #f8f9fa; /* Couleur de fond si l'image a des transparences */
    }
    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Assure que l'image couvre l'espace sans se déformer */
        transition: transform 0.3s ease, filter 0.3s ease;
        filter: grayscale(40%); /* Applique un filtre N&B pour un ton plus sobre */
    }
    .card:hover .card-img-top {
        transform: scale(1.05);
        filter: grayscale(20%); /* Réduit le filtre au survol */
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .separator {
        max-width: 100px;
        margin: 2rem auto;
        height: 3px;
        background: linear-gradient(to right, transparent, var(--vert-sapin), transparent);
    }
</style>
@endsection