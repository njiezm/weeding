<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gilles & Maëva | Mariage</title>

    <!-- Favicon avec ton logo G&M -->
    <link rel="icon" href="/images/logo-metg.png" type="image/png">
    <link rel="shortcut icon" href="/images/logo-metg.png" type="image/png">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Ton CSS -->
    <link href="/css/mariage.css" rel="stylesheet">

    <!-- META Description -->
    <meta name="description" content="Le grand jour approche ! Découvrez notre application de mariage avec infos, jeux et souvenirs.">

    <!-- Open Graph (aperçu lien WhatsApp / Messenger / Facebook / Telegram) -->
<meta property="og:title" content="Gilles & Maëva – Notre mariage">
<meta property="og:description" content="Le grand jour approche ! Consultez notre application de mariage pour toutes les infos et nos jeux.">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ asset('images/preview-mariage.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Gilles & Maëva – Notre mariage">
<meta name="twitter:description" content="Le grand jour approche ! Consultez notre application de mariage pour toutes les infos et nos jeux.">
<meta name="twitter:image" content="{{ asset('images/preview-mariage.png') }}">

    <!-- Icône Apple pour iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/logo-metg.png">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/home">
            <span class="logo-text">G&M</span>
        </a>
    </div>
</nav>

<div class="main-content">
    <div class="container my-5">
        @yield('content')
    </div>
</div>

<footer class="footer-pro py-3 mt-5">
    <div class="container text-center">
        <p class="mb-0">© 2025 Gilles & Maëva. Tous droits réservés.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
