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
                <h3 class="menu-section-title text-center">Le Dîner des Mariés</h3>
                
                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Amuse-Bouche & Mise en Bouche</span>
                        <p class="dish-description">
                            Cromesquis de Homard à la truffe noire, émulsion de Champagne et poivre de Sichuan.
                        </p>
                    </div>
                </div>

                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Plat Signature</span>
                        <p class="dish-description">
                            Filet de Veau confit aux morilles, réduction de Porto vieilli, et son gratin Dauphinois aux herbes fines.
                        </p>
                    </div>
                </div>

                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">La Note Sucrée</span>
                        <p class="dish-description">
                            Dôme Passion-Mangue et sa dacquoise à la noix de coco, coulis Doré et chantilly légère.
                        </p>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="menu-vege" role="tabpanel">
                <h3 class="menu-section-title text-center">L'Élégance Végétale</h3>
                
                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Entrée Végétarienne</span>
                        <p class="dish-description">
                            Velouté onctueux de courge butternut aux éclats de noisettes torréfiées et huile de sésame.
                        </p>
                    </div>
                </div>

                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Plat Végétarien</span>
                        <p class="dish-description">
                            Mille-feuille de légumes de saison grillés, chèvre frais, et son pesto maison au basilic.
                        </p>
                    </div>
                </div>
                
                <div class="card-callout text-center">
                    <i class="fa-solid fa-info-circle me-2"></i> Ce plat sera servi automatiquement si vous avez sélectionné "Végétarien" lors de votre RSVP.
                </div>
            </div>

            <div class="tab-pane fade" id="menu-enfant" role="tabpanel">
                <h3 class="menu-section-title text-center">Le Menu des Petits Gourmands</h3>

                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Plat Ludique</span>
                        <p class="dish-description">
                            Mini-burger de boeuf de qualité ou Nuggets de poulet fermier, servis avec des frites maison.
                        </p>
                    </div>
                </div>
                
                <div class="menu-card">
                    <div class="p-4">
                        <span class="dish-name">Dessert Enfant</span>
                        <p class="dish-description">
                            Fontaine de chocolat et fruits frais à tremper, ou glace artisanale.
                        </p>
                    </div>
                </div>

                <div class="card-callout text-center">
                    <i class="fa-solid fa-user-friends me-2"></i> Ce menu est prévu pour les enfants de moins de 12 ans.
                </div>
            </div>

        </div> <div class="card mt-5 p-4 border-0 shadow-lg" style="background-color: var(--vert-tres-clair); border-radius: 20px;">
            <h4 class="text-center" style="font-family:var(--font-pro); color:var(--vert-sapin); font-weight:700;">
                <i class="fa-solid fa-notes-medical me-2 text-dore-accent"></i> Allergies & Régimes Spéciaux
            </h4>
            <p class="text-center text-muted">
                Votre confort est notre priorité. Veuillez nous informer de toute allergie ou besoin alimentaire non couvert par les options ci-dessus.
            </p>

            <form action="/api/save-diet-info" method="POST" class="mt-3">
                <div class="mb-3">
                    <label for="regime" class="form-label fw-bold">Votre Option de Repas :</label>
                    <select id="regime" name="regime" class="form-select">
                        <option value="classique" selected>Menu Classique</option>
                        <option value="vegetarien">Option Végétarienne</option>
                        <option value="enfant">Menu Enfant (si applicable)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="allergies" class="form-label fw-bold">Allergies/Notes Importantes :</label>
                    <textarea id="allergies" name="allergies" rows="3" class="form-control" placeholder="Ex: Sans gluten, allergie aux noix, autre..."></textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-pro-primary mt-3">
                        Enregistrer Mes Choix
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection