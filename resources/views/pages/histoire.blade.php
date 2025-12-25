@extends('layout')
@section('content')

<div class="container">
    <h2 class="text-center mb-5" style="font-family:var(--font-elegant); font-size:3rem; color:var(--dore-accent);">
        🕊️ Notre Histoire
    </h2>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            <ul class="timeline">

                <!-- 2014 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">2014</span>
                        <h4 class="timeline-heading">Une rencontre sur le sable 🏐</h4>
                        <div class="timeline-body">
                            <p>
                                C’est en 2014, lors d’un match de beach-volley entre amis, que nos chemins se sont croisés.
                                Nous ne savions pas encore que cette rencontre marquerait le début d’une aventure bien plus grande.
                                Entre sourires, esprit d’équipe et légèreté, une connexion naturelle s’est installée.
                            </p>
                            <!-- Photo d'avril 2016 -->
                            <img src="/images/histoire/avril-2016.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Photo d'avril 2016">
                        </div>
                    </div>
                </li>

                <!-- 2015 - 2017 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">2015 - 2017</span>
                        <h4 class="timeline-heading">Se découvrir, se rapprocher 💬</h4>
                        <div class="timeline-body">
                            <p>
                                Après cette première rencontre, les occasions de se revoir se multiplient.
                                Des discussions qui durent, des moments partagés, des souvenirs qui s’accumulent.
                                Peu à peu, l’amitié se transforme en quelque chose de plus profond, fait de complicité et d’évidence.
                            </p>
                            <!-- Photo de mai 2016 -->
                            <img src="/images/histoire/mai-2016.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Photo de mai 2016">
                            <!-- Photo de juin 2017 -->
                            <img src="/images/histoire/juin-2017.jpg" class="img-fluid rounded shadow-sm mt-2" alt="Photo de juin 2017">
                        </div>
                    </div>
                </li>

                <!-- 2018 - 2019 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">2018 - 2019</span>
                        <h4 class="timeline-heading">Voyager et créer des souvenirs ✈️</h4>
                        <div class="timeline-body">
                            <p>
                                Avant de poser définitivement nos valises, nous avons pris le temps de voyager ensemble.
                                Des escapades, des découvertes, des paysages nouveaux…
                                Chaque voyage a renforcé notre lien, nous apprenant à nous connaître autrement et à grandir ensemble, loin du quotidien.
                            </p>
                            <!-- Photo du premier voyage en Guadeloupe -->
                            <img src="/images/histoire/guadeloupe-2017.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Voyage en Guadeloupe en décembre 2017">
                        </div>
                    </div>
                </li>
                
                <!-- 2020 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">2020</span>
                        <h4 class="timeline-heading">Emménager ensemble 🏡</h4>
                        <div class="timeline-body">
                            <p>
                                En 2020, une décision importante s’impose naturellement : vivre ensemble.
                                Partager un toit, un quotidien, des projets, c’était une nouvelle étape, plus engagée, plus profonde.
                                Un foyer se construit, jour après jour, avec amour, patience et bienveillance.
                            </p>
                        </div>
                    </div>
                </li>

                <!-- 2021 - 2023 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">2021 - 2023</span>
                        <h4 class="timeline-heading">Grandir ensemble 🌱</h4>
                        <div class="timeline-body">
                            <p>
                                Ces années sont celles de la stabilité et de la construction.
                                Des défis surmontés à deux, des projets qui prennent forme, des rêves partagés.
                                Une relation qui s’ancre, s’affirme et devient une évidence.
                            </p>
                            <!-- Photo de la croisière en Barbade -->
                            <img src="/images/histoire/barbade-2023.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Croisière en Barbade en avril 2023">
                            <!-- Photo du festival La Baccanal -->
                            <img src="/images/histoire/baccanal-2023.jpg" class="img-fluid rounded shadow-sm mt-2" alt="Festival La Baccanal en août 2023">
                        </div>
                    </div>
                </li>
                
                <!-- Juillet 2024 -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">Juillet 2024</span>
                        <h4 class="timeline-heading">La demande en mariage 💍</h4>
                        <div class="timeline-body">
                            <p>
                                En juillet 2024, après tout ce chemin parcouru, une question change tout.
                                Une demande en mariage, chargée d’émotion et de promesses.
                                Un “oui” sincère, symbole de tout ce que nous avons déjà vécu et de tout ce qui reste à venir.
                            </p>
                            <!-- Ici, vous pouvez ajouter une photo de la demande si vous en avez une -->
                            <!-- <img src="/images/histoire/demande-2024.jpg" class="img-fluid rounded shadow-sm mt-3" alt="La demande en mariage"> -->
                        </div>
                    </div>
                </li>
                
                <!-- Aujourd'hui et demain -->
                <li class="timeline-item">
                    <div class="timeline-point"></div>
                    <div class="timeline-panel">
                        <span class="timeline-date">Aujourd'hui et demain</span>
                        <h4 class="timeline-heading">Le début d'un nouveau chapitre ✨</h4>
                        <div class="timeline-body">
                            <p>
                                Aujourd’hui, nous continuons d’écrire notre histoire, entourées de nos proches.
                                Le mariage n’est pas une fin, mais le début d’un nouveau chapitre, fait de projets, de voyages, de rires et d’amour.
                            </p>
                        </div>
                    </div>
                </li>

            </ul>

            <p  style="color: var(--dore-accent);" class="text-center mt-5 p-3 fs-5" style="border-top: 1px solid var(--vert-tres-clair); color:var(--vert-sapin);">
                <i class="fa-solid fa-heart me-2" style="color: var(--dore-accent);"></i> Et l'aventure continue...
            </p>
            
        </div>
    </div>
</div>

@endsection