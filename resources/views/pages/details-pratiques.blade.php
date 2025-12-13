@extends('layout')
@section('content')

<h2 class="text-center details-heading">
    Détails Pratiques & Logistique 🗺️
</h2>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <div class="details-section">
            <h3 class="fw-bold"><i class="fa-solid fa-hotel me-2"></i> Où Se Loger ?</h3>
            <p class="text-muted">
                Nous vous recommandons les établissements suivants à proximité des lieux de réception.
            </p>

            @foreach($hotels as $hotel)
            <div class="info-item mb-3 p-3" style="border: 1px solid var(--vert-tres-clair); border-radius: 10px;">
                <p class="fw-bold mb-1" style="color:var(--vert-sapin); font-size: 1.1rem;">{{ $hotel->nom }}</p>
                <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i> {{ $hotel->adresse }}</p>
                <p class="mb-1"><i class="fa-solid fa-phone me-2"></i> {{ $hotel->tel }}</p>
                <a href="{{ $hotel->link }}" target="_blank" class="btn btn-sm btn-details-action">
                    Réserver / Voir les tarifs <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                </a>
            </div>
            @endforeach
        </div>

        <div class="details-section">
            <h3 class="fw-bold"><i class="fa-solid fa-car-side me-2"></i> Transport & Accès</h3>

            <div class="info-item">
                <i class="fa-solid fa-bus me-2"></i>
                **Navettes :** Des navettes seront prévues entre l'église et la réception après la cérémonie. Les horaires seront affichés à l'église.
            </div>
            <div class="info-item">
                <i class="fa-solid fa-square-parking me-2"></i>
                **Parking :** Un grand parking gratuit sera disponible à proximité immédiate du Domaine [Nom du Domaine].
            </div>
            <div class="info-item">
                <i class="fa-solid fa-taxi me-2"></i>
                **Taxis :** Liste des compagnies de taxis locales : [Lien vers un PDF/une liste].
            </div>
        </div>
        
        <div class="details-section">
            <h3 class="fw-bold"><i class="fa-solid fa-shirt me-2"></i> Code Vestimentaire</h3>
            <p class="text-center lead" style="color: var(--dore-accent); font-family: var(--font-elegant);">
                Chic & Décontracté
            </p>
            <p class="text-muted text-center">
                Nous souhaitons une ambiance élégante, mais où vous êtes à l'aise ! Évitez simplement les couleurs trop claires (blanc/ivoire/crème).
            </p>
            <p class="text-center fw-bold mt-3" style="color: var(--vert-sapin);">
                <i class="fa-solid fa-palette me-2"></i> Couleurs d'accent : Vert, Doré, Bleu Marine.
            </p>
        </div>

        <div class="details-section">
            <h3 class="fw-bold"><i class="fa-solid fa-headset me-2"></i> Contacts d'Urgence / Logistique</h3>
            
            <p class="text-muted">
                Si vous avez une question de dernière minute le jour J, veuillez contacter notre organisatrice :
            </p>
            <div class="info-item fw-bold">
                <i class="fa-solid fa-user me-2"></i> {{ $contact_mariage }}
            </div>
            <div class="info-item">
                <i class="fa-solid fa-mobile-alt me-2"></i>
                <a href="tel:{{ $contact_tel }}" class="text-decoration-none" style="color: var(--vert-sapin);">{{ $contact_tel }}</a>
            </div>
            <div class="info-item">
                <i class="fa-solid fa-envelope me-2"></i>
                <a href="mailto:{{ $contact_email }}" class="text-decoration-none" style="color: var(--vert-sapin);">{{ $contact_email }}</a>
            </div>
        </div>

    </div>
</div>

@endsection