@extends('layout')
@section('content')

<h2 class="text-center treasure-heading">
    <i class="fa-solid fa-map-marked-alt me-2"></i> Chasse au Trésor Photo
</h2>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <p class="text-center lead mb-4 fw-bold" style="color:var(--vert-sapin);">
            Votre mission : immortaliser les moments et les objets cachés !
        </p>
        
        @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
        @endif

        <div class="missions-box">
            <h3>Liste des Indices à Capturer</h3>
            
            <div class="mission-item">
                <i class="fa-solid fa-camera me-2"></i> **Mission 1 :** L'objet le plus ancien de la salle.
            </div>
            <div class="mission-item">
                <i class="fa-solid fa-camera me-2"></i> **Mission 2 :** Un selfie avec quelqu'un que vous venez de rencontrer.
            </div>
            <div class="mission-item">
                <i class="fa-solid fa-camera me-2"></i> **Mission 3 :** La meilleure vue du ciel au Domaine.
            </div>
            <div class="mission-item">
                <i class="fa-solid fa-camera me-2"></i> **Mission 4 :** Un verre de Maëva et la pochette de Gilles (où se trouvent-ils ?).
            </div>
            <div class="mission-item">
                <i class="fa-solid fa-camera me-2"></i> **Mission 5 :** Le détail décoratif que vous préférez.
            </div>

            <p class="text-center mt-3 text-muted small">
                Le grand gagnant sera celui qui aura trouvé le plus d'indices de manière originale !
            </p>
        </div>

        <div class="submission-card">
            <h4 class="text-center fw-bold mb-3" style="color:var(--vert-sapin);">
                Soumettre un Indice Trouvé
            </h4>

            <form method="POST" action="{{ route('jeux.chasse-photo.submit') }}" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3 g-2">
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="prenom" placeholder="Votre Prénom" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="nom" placeholder="Votre Nom" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="indice" class="form-label fw-bold text-muted">Nom de l'indice que vous soumettez :</label>
                    <input type="text" class="form-control form-control-lg" name="indice" 
                           placeholder="Ex: Mission 1 : L'objet le plus ancien" required>
                </div>

                <div class="mb-4">
                    <label for="photo" class="form-label fw-bold text-muted">Téléchargez votre photo preuve 📷</label>
                    <input type="file" id="photo" class="form-control" name="photo" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-submit-treasure w-100 btn-lg">
                    <i class="fa-solid fa-paper-plane me-2"></i> Envoyer ma photo & Valider l'indice
                </button>
            </form>
            
            <p class="mt-3 text-center text-muted small">
                Vos photos seront visibles par les mariés (et potentiellement dans la Galerie participative) après validation.
            </p>
        </div>

    </div>
</div>

@endsection