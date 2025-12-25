@extends('layout')
@section('content')

@php
// Logique du décompte (inchangée)
$weddingDate = \Carbon\Carbon::create(2025, 12, 26);
$today = \Carbon\Carbon::now();
$daysLeft = $today->diffInDays($weddingDate, false);

// Définition des éléments du menu avec ICÔNES PRO
$menuItems = [
    // Bloc Information Clé (Priorité)
    ['Notre Histoire', '/notre-histoire', 'fa-book-open', 'Découvrez notre parcours.','col-sm-6 col-md-4'],
    ['Cérémonie', '/ceremonie-religieuse', 'fa-church', 'Lieu, heure et plan d\'accès.', 'col-sm-6 col-md-4'],
    ['Mairie', '/mairie', 'fa-gavel', 'Les formalités civiles.', 'col-sm-6 col-md-4'],
    
    // Bloc Interaction (UX & Mémorable)
    ['Détails Pratiques', '/details-pratiques', 'fa-map-location-dot', 'Hébergement, transport, parking.', 'col-sm-6 col-md-4'],
    ['Menu & Allergies', '/menu', 'fa-utensils', 'Consultez le repas et informez-nous.', 'col-sm-6 col-md-4'],
    ['Liste de Mariage / Urne', '/urne', 'fa-gift', 'Notre petit souhait.', 'col-sm-6 col-md-4'],

    // Bloc Souvenirs
    ['Galerie', '/galerie', 'fa-camera-retro', 'Partagez et voyez les photos.', 'col-sm-6 col-md-4'],
    ['Livre d\'Or', '/livre-or', 'fa-feather-pointed', 'Laissez un mot aux mariés.', 'col-sm-6 col-md-4'],
    
    // Bloc Jeux (pour l'engagement)
    ['Qui de nous 2 ?', '/jeux/qui-de-nous-2', 'fa-question', 'Testez vos connaissances !', 'col-sm-6 col-md-4'],
    ['Chasse Photo', '/jeux/chasse-photo', 'fa-magnifying-glass-chart', 'Un jeu amusant pour la journée.', 'col-sm-6 col-md-4'],

    // Ajoutez ces éléments au tableau $menuItems
    ['Mots Croisés', '/jeux/mots-croises', 'fa-puzzle-piece', 'Testez vos connaissances !', 'col-sm-6 col-md-4'],
    ['Memory', '/jeux/memory', 'fa-brain', 'Retrouvez les paires de photos !', 'col-sm-6 col-md-4'],
];
@endphp

<div class="banner mb-5 text-center p-4 p-md-5">
    <h2>Bienvenue dans votre Espace Mariage</h2>
    
    <div class="countdown-pro mt-4">
    <p id="countdown-text" class="mb-0 fs-5 fw-semibold"></p>
</div>

    
    <div class="key-info mt-4 pt-3 border-top border-opacity-25">
        <span class="d-block d-sm-inline mx-3"><i class="fa-solid fa-calendar-alt me-2 text-gold-accent"></i> 26 Décembre 2025</span>
        <span class="d-block d-sm-inline mx-3 mt-2 mt-sm-0"><i class="fa-solid fa-location-dot me-2 text-gold-accent"></i> Domaine de l'Apaloosa, François, Martinique</span>
    </div>
</div>

<div class="row g-4">
    @foreach($menuItems as [$title, $url, $icon, $description, $colClass])
    <div class="col-6 col-md-4"> 
        <a href="{{ $url }}" class="text-decoration-none">
            <div class="card card-wedding h-100 p-3 p-md-4">
                <div class="text-center">
                    <i class="fa-solid {{ $icon }} icon-main-tile mb-3"></i>
                    
                    <h5 class="card-title">{{ $title }}</h5>
                    
                    <p class="card-text card-description">{{ $description }}</p>
                    
                    <span class="access-link">Accéder <i class="fa-solid fa-chevron-right ms-1"></i></span>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="dress-code-banner mt-5 p-3 text-center">
    <i class="fa-solid fa-shirt me-2"></i> 
    <span class="fw-bold">Code Vestimentaire :</span> Chic & Champêtre. Couleur vert sapin et rouille.
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // 🔑 Dates clés
    const weddingStart = new Date("2025-12-26T14:00:00");
    const receptionStart = new Date("2025-12-26T17:00:00");

    const countdownEl = document.getElementById("countdown-text");

    function formatTime(diff) {
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        return `
            <strong class="text-gold-accent">
                ${days}j ${hours}h ${minutes}m ${seconds}s
            </strong>
        `;
    }

    function updateCountdown() {
        const now = new Date();

        // 🟢 AVANT LE MARIAGE
        if (now < weddingStart) {
            const diff = weddingStart - now;
            countdownEl.innerHTML = `💍 Début de la cérémonie dans ${formatTime(diff)}`;

        // 🟡 ENTRE MARIAGE ET RÉCEPTION
        } else if (now >= weddingStart && now < receptionStart) {
            const diff = receptionStart - now;
            countdownEl.innerHTML = `🥂 Début de la réception dans ${formatTime(diff)}`;

        // 🔴 APRÈS LA RÉCEPTION
        } else {
            countdownEl.innerHTML = `🎉 La fête est lancée ! Profitez de ce moment magique 💖`;
            clearInterval(timer);
        }
    }

    updateCountdown();
    const timer = setInterval(updateCountdown, 1000);
});
</script>

@endsection