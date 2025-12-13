@extends('layout')
@section('content')

<h2 class="text-center ceremony-heading">
    Cérémonie Religieuse 💍
</h2>

<div class="row">
    <div class="col-lg-8 mx-auto">

        <div class="status-banner-live text-center">
            <i class="fa-solid fa-signal me-2"></i> 
            <span class="fw-bold">STATUT EN DIRECT :</span> Nous sommes actuellement à l'étape : 
            <span class="current-step">Le Chant d'Entrée</span>
        </div>

        <div class="location-card text-center mb-5">
            <h4 class="fw-bold" style="color:var(--vert-sapin);">Église Sainte-Trinité du Bonheur</h4>
            <p class="mb-1"><i class="fa-solid fa-clock me-2 text-dore-accent"></i> **Heure d'arrivée des invités :** 14h30</p>
            <p><i class="fa-solid fa-bell me-2 text-dore-accent"></i> **Début Précis de la Cérémonie :** 15h00</p>
            <p class="mt-3">
                <i class="fa-solid fa-map-pin me-2 text-dore-accent"></i> Adresse : 12 Rue de l'Amour Éternel, 97220 Le Paradis.
                <a href="#" class="btn btn-sm ms-3" style="background-color: var(--vert-sapin); color: var(--champagne-clair);">Voir sur la carte</a>
            </p>
        </div>
        
        <h3 class="fw-bold text-center mb-4" style="color:var(--vert-sapin); font-family:var(--font-pro);">
            Le Livret de Cérémonie Digital
        </h3>

        <div class="accordion ceremony-accordion" id="ceremonyAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <i class="fa-solid fa-music me-3"></i> 1. Chant d'Entrée & Procession
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        <p>
                            **Chant :** <span class="hymn-title">"Hymne à l'Amour"</span> (Edith Piaf, version instrumentale).
                        </p>
                        <p>
                            Entrée des familles, des témoins, et enfin, l'entrée de la Mariée au bras de son père.
                        </p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <i class="fa-solid fa-book-open me-3"></i> 2. Première Lecture (par [Témoin/Lecteur])
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        <p>
                            **Texte :** L'Épître aux Corinthiens (Chapitre 13, Le Chant de l'Amour).
                        </p>
                        <p class="reading-text">
                            "L’amour est patient, l’amour est serviable. Il n’est pas jaloux, il ne se vante pas, il ne se gonfle pas d’orgueil..."
                        </p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        <i class="fa-solid fa-hand-holding-heart me-3"></i> 3. Le Moment Solennel : Vœux & Alliances
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        <p>
                            Échange des consentements personnels, bénédiction et échange des alliances.
                        </p>
                        <p class="hymn-title">Musique de Fond : "Canon en Ré Majeur" (Pachelbel).</p>
                        <p class="fw-bold mt-3">
                            <i class="fa-solid fa-kiss-wink-heart me-2 text-dore-accent"></i> Le moment tant attendu : Le Baiser !
                        </p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                        <i class="fa-solid fa-comment-dots me-3"></i> 4. Mots Personnels (Famille & Amis)
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        <p>
                            Discours émouvants de la Mère de la Mariée et du Témoin du Marié.
                        </p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                        <i class="fa-solid fa-dove me-3"></i> 5. Signature des Registres & Sortie
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        <p>
                            **Chant de Sortie :** <span class="hymn-title">"Happy"</span> (Pharrell Williams) - pour la joie !
                        </p>
                        <p>
                            Félicitez les mariés à la sortie de l'église (riz et confettis sont autorisés !).
                        </p>
                    </div>
                </div>
            </div>
            
        </div> </div>
</div>

@endsection