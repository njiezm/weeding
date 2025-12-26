<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Affiche la page d'hommage aux défunts.
     *
     * @return \Illuminate\View\View
     */
    public function penseePour()
    {
        // Les données sont statiques ici, mais pourraient venir d'une base de données plus tard.
        // 'photo' doit être le chemin vers l'image depuis le dossier 'public'.
        $decedents = [
            (object) [
                'name' => 'Guy-Albert ZAMON', 
                'photo' => 'images/decedents/gaz.jpg', 
                'dates' => '1964 - 2025',
                'message' => 'Un père aimant, protecteur et attentioné. A jamais dans nos cœurs. Un beau-père exceptionnel.'
            ],
            (object) [
                'name' => 'Elvire MAXIMIN', 
                'photo' => 'images/decedents/elvire.jpg', 
                'dates' => '1965 - 2025',
                'message' => 'Toujours dans nos cœurs, ma titie d\'amour on ne t\'oublie pas.'
            ],
            (object) [
                'name' => 'Isis LABYLLE', 
                'photo' => 'images/decedents/isis.jpg', 
                'dates' => '1941 - 2017',
                'message' => 'Ma mamie de très fortes pensées vers toi, Je t\'aime fort !.'
            ],
            (object) [
                'name' => 'Tertulien BUVAL', 
                'photo' => 'images/decedents/buval.jpg', 
                'dates' => '1939 - 2003',
                'message' => 'Papi repose en paix, une étoile qui brille dans le ciel.'
            ],
            // Ajoutez autant de personnes que nécessaire
        ];

        return view('pensee-pour', compact('decedents'));
    }

    // ... autres méthodes du contrôleur
}