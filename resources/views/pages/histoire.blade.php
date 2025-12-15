@extends('layout')
@section('content')

<h2 class="text-center mb-5" style="font-family:var(--font-elegant); font-size:3rem; color:var(--dore-accent);">
    Notre histoire 🥂
</h2>

<div class="row">
    <div class="col-lg-10 mx-auto">
        
        <ul class="timeline">

            <li class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-panel">
                    <span class="timeline-date">Septembre 2018</span>
                    <h4 class="timeline-heading">Le Premier Regard 👀</h4>
                    <div class="timeline-body">
                        <p>
                            Dans ce café parisien, nos chemins se sont croisés. Un simple échange de regards
                            a suffi à nous faire comprendre que cette rencontre n'était pas un hasard. C'était le début.
                        </p>
                    </div>
                </div>
            </li>

            <li class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-panel">
                    <span class="timeline-date">Juillet 2019</span>
                    <h4 class="timeline-heading">Première Aventure Commune ✈️</h4>
                    <div class="timeline-body">
                        <p>
                            Notre voyage à Rome, au milieu des ruines et des glaces italiennes, a confirmé notre
                            connexion. C'est là que Gilles a su que Maëva était la bonne, et inversement !
                        </p>
                    </div>
                </div>
            </li>

            <li class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-panel">
                    <span class="timeline-date">Janvier 2021</span>
                    <h4 class="timeline-heading">Notre Cocon 🔑</h4>
                    <div class="timeline-body">
                        <p>
                            Acheter et aménager notre premier appartement ensemble. Un cap important qui a transformé
                            les "miens" et "tiens" en "notre". Les meilleures soirées cinéma ont commencé ici.
                        </p>
                    </div>
                </div>
            </li>
            
            <li class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-panel">
                    <span class="timeline-date">Décembre 2024</span>
                    <h4 class="timeline-heading">La Grande Question 💍</h4>
                    <div class="timeline-body">
                        <p>
                            Sous les aurores boréales (ou tout autre lieu romantique), Gilles a posé LE genou à terre.
                            Maëva a dit OUI, bien sûr ! Le compte à rebours pour le grand jour était lancé.
                        </p>
                    </div>
                </div>
            </li>
            
            <li class="timeline-item">
                <div class="timeline-point"></div>
                <div class="timeline-panel">
                    <span class="timeline-date">26 Décembre 2025</span>
                    <h4 class="timeline-heading">Le Jour J - À suivre ! 🎉</h4>
                    <div class="timeline-body">
                        <p>
                            Le meilleur reste à venir ! Nous avons hâte de célébrer le début de notre nouvelle vie
                            avec vous tous. Merci de faire partie de notre histoire.
                        </p>
                    </div>
                </div>
            </li>

        </ul>

        <p class="text-center mt-5 p-3 fs-5" style="border-top: 1px solid var(--vert-tres-clair); color:#e8e8e8; /*var(--vert-sapin);*/">
            <i class="fa-solid fa-heart me-2" style="color: var(--dore-accent);"></i> Et l'aventure continue...
        </p>
        
    </div>
</div>

@endsection