@extends('layout')
@section('content')

<h2 class="text-center mb-5" style="font-family:var(--font-elegant); font-size:3rem; color:var(--dore-accent);">
    Notre Carte de Réception
</h2>

<div class="row">
    <div class="col-lg-10 mx-auto">
        
        <ul class="nav nav-tabs justify-content-center nav-menu-tabs mb-4" id="menuTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="menu-classique-tab" data-bs-toggle="tab" data-bs-target="#menu-classique" type="button" role="tab">
                    <i class="fa-solid fa-champagne-glasses me-2"></i> Menu Classique
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="menu-vege-tab" data-bs-toggle="tab" data-bs-target="#menu-vege" type="button" role="tab">
                    <i class="fa-solid fa-leaf me-2"></i> Option Végétarienne
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="menu-enfant-tab" data-bs-toggle="tab" data-bs-target="#menu-enfant" type="button" role="tab">
                    <i class="fa-solid fa-child me-2"></i> Menu Enfant
                </button>
            </li>
        </ul>

        <div class="tab-content" id="menuTabsContent">
            
            <div class="tab-pane fade show active" id="menu-classique" role="tabpanel">
    <h3 class="menu-section-title text-center">Menu de Mariage</h3>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">✨ Entrée</span>
            <p class="dish-description">
                Soupe traditionnelle de pâté en pot de bœuf, délicatement parfumée.
            </p>
        </div>
    </div>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🥗 Buffet froid</span>
            <p class="dish-description">
                • Tourte fine au poisson<br>
                • Ailes de poulet marinées<br>
                • Tarte salée au saumon et au jambon glacé à l’ananas<br>
                • Morue grillée<br>
                • Assortiment de crudités : laitue, chou, carottes<br>
                • Sauces : vinaigrette fromage blanc et nature
            </p>
        </div>
    </div>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🍴 Plats principaux</span>
            <p class="dish-description">
                • Coq roussi traditionnel (majorité)<br>
                • Poisson braisé au four (option)
            </p>
            <p class="dish-description mt-2">
                <strong>Accompagnements :</strong><br>
                • Gratin dauphinois<br>
                • Riz au curcuma<br>
                • Riz blanc
            </p>
        </div>
    </div>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🧁 Desserts</span>
            <p class="dish-description">
                • Salade de fruits frais de saison<br>
                • Assortiment de glaces<br>
                • Pièce montée aux fruits rouges
            </p>
        </div>
    </div>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🍹 Boissons</span>
            <p class="dish-description">
                • Champagne Boutet<br>
                • Bières : Heineken, Lorraine, panaché grenadine, Champomy<br>
                • Vins : blanc, rouge et rosé<br>
                • Eau de coco fraîche<br>
                • Jus : prune de cythère, goyave, cerise<br>
                • Sodas : Coca-Cola, Sprite, Didier eaux plate & pétillante<br>
                • Rhum blanc & rhum vieux (citron & sucre)<br>
                • Martini
            </p>
        </div>
    </div>
</div>

            <div class="tab-pane fade" id="menu-vege" role="tabpanel">
    <h3 class="menu-section-title text-center">Option Végétarienne</h3>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🌱 Composition du menu</span>
            <p class="dish-description">
                • Buffet froid : crudités, tourte végétarienne, accompagnements<br>
                • Poisson<br>
                • Riz au curcuma et riz blanc<br>
                • Gratin dauphinois<br>
                • Salade de fruits, glaces et pièce montée
            </p>
        </div>
    </div>

    <div class="card-callout text-center">
        <i class="fa-solid fa-info-circle me-2"></i>
        Cette option est servie sur demande lors du choix du repas.
    </div>
</div>


            <div class="tab-pane fade" id="menu-enfant" role="tabpanel">
    <h3 class="menu-section-title text-center">Menu Enfant</h3>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🍗 Plat</span>
            <p class="dish-description">
                • Ailes de poulet ou poisson grillé<br>
                • Riz blanc
            </p>
        </div>
    </div>

    <div class="menu-card">
        <div class="p-4">
            <span class="dish-name">🍨 Dessert</span>
            <p class="dish-description">
                • Glace<br>
                • Jus de fruits
            </p>
        </div>
    </div>

    <div class="card-callout text-center">
        <i class="fa-solid fa-user-friends me-2"></i>
        Menu réservé aux enfants.
    </div>
</div>

        </div> <div class="card mt-5 p-4 border-0 shadow-lg" style="background-color: var(--vert-tres-clair); border-radius: 20px;">
            <h4 class="text-center" style="font-family:var(--font-pro); color:var(--vert-sapin); font-weight:700;">
                <i class="fa-solid fa-notes-medical me-2 text-dore-accent"></i> Allergies & Régimes Spéciaux
            </h4>
            <p class="text-center text-muted">
                Votre confort est notre priorité. Veuillez nous informer de toute allergie ou besoin alimentaire non couvert par les options ci-dessus.
            </p>

            <div class="text-center mt-3">
                <a href="/contact" class="btn btn-dore-accent">
                    <i class="fa-solid fa-envelope me-2"></i> Nous Contacter
                </a>
            </div>
        </div>

    </div>
</div>

@endsection