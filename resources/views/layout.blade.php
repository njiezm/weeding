<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gilles & Maëva | Mariage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/mariage.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/home">
            <span class="logo-text">G&M</span> <!--i class="fa-solid fa-ring icon-ring"></!--i-->
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