@extends('layout')
@section('content')

<h2 class="text-center details-heading">
    Détails Pratiques & Logistique
</h2>

<div class="row justify-content-center">
    <div class="col-lg-9">

        {{-- HÉBERGEMENT --}}
        <div class="details-section">
            <h3 class="fw-bold"><i class="fa-solid fa-hotel me-2"></i> Où se loger ?</h3>

            <ul class="list-unstyled mb-3">
                <li class="info-item"><i class="fa-solid fa-bed me-2"></i> Hôtel Plein Soleil</li>
                <li class="info-item"><i class="fa-solid fa-bed me-2"></i> La Frégate Bleue</li>
                <li class="info-item"><i class="fa-solid fa-bed me-2"></i> Village de la Pointe</li>
            </ul>

            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                <iframe 
                    src="https://www.google.com/maps?q=Hôtel+Plein+Soleil+Martinique&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>


        {{-- TRANSPORT --}}
        <div class="details-section">
    <h3 class="fw-bold"><i class="fa-solid fa-car-side me-2"></i> Transport & Accès</h3>

    <div class="info-item">
        <i class="fa-solid fa-square-parking me-2"></i>
        <strong>Parking :</strong> Un parking gratuit est disponible sur le site du Domaine de l'Apaloosa pour tous les invités.
    </div>

    <div class="info-item">
        <i class="fa-solid fa-taxi me-2"></i>
        <strong>Taxis :</strong>
        <a href="https://www.martiniquetaxi.com" target="_blank" class="text-decoration-none">
            Martinique Taxi
        </a>
        <br>
        Téléphone : <a href="tel:+59659636362" class="text-decoration-none">+596 596 63 63 62</a>

        <div class="text-center mt-3">
        <a href="https://wa.me/59659636362"
           target="_blank"
           class="btn btn-success rounded-pill px-4">
            <i class="fa-brands fa-whatsapp me-2"></i>
            Contacter Martinique Taxi sur WhatsApp
        </a>
    </div>
    </div>
</div>

        
        {{-- CODE VESTIMENTAIRE --}}
        <div class="details-section text-center">
    <h3 class="fw-bold"><i class="fa-solid fa-shirt me-2"></i> Code vestimentaire</h3>

    <p class="lead" style="color: var(--dore-accent); font-family: var(--font-elegant);">
        Chic & Élégant
    </p>

    <div class="d-flex justify-content-center gap-3 mt-3">
        <span class="color-dot" style="background:#0b3d2e;"></span>
        <span class="color-dot" style="background:#b55239;"></span>
        <span class="color-dot" style="background:#ffffff; border:1px solid #ccc;"></span>
    </div>

    <p class="fw-bold mt-2" style="color: var(--vert-sapin);">
        Vert sapin • Rouille • Blanc
    </p>
</div>


        {{-- CONTACT --}}
        <div class="details-section">
    <h3 class="fw-bold"><i class="fa-solid fa-headset me-2"></i> Contact</h3>

    <div class="info-item fw-bold">
        <i class="fa-solid fa-user me-2"></i> Jade
    </div>

    <div class="info-item">
        <i class="fa-solid fa-mobile-alt me-2"></i>
        <a href="tel:0696388072" class="text-decoration-none">
            06 96 38 80 72
        </a>
    </div>

    <div class="info-item">
        <i class="fa-solid fa-envelope me-2"></i>
        <a href="mailto:Jade.buval@gmail.com" class="text-decoration-none">
            jade.buval@gmail.com
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="https://wa.me/596696388072"
           target="_blank"
           class="btn btn-success rounded-pill px-4">
            <i class="fa-brands fa-whatsapp me-2"></i>
            Contacter Jade sur WhatsApp
        </a>
    </div>
</div>


    </div>
</div>

@endsection
