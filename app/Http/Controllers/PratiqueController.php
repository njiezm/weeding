<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PratiqueController extends Controller
{
    /**
     * Affiche la page des détails pratiques (Hébergement, Transport, etc.).
     */
    public function index()
    {
        // Les données ici sont statiques pour l'exemple, mais pourraient venir d'une DB
        $data = [
            'hotels' => [
                (object)['nom' => 'Le Grand Hôtel du Bonheur', 'adresse' => '1 Rue de la Joie', 'tel' => '+33 1 23 45 67 89', 'link' => '#'],
                (object)['nom' => 'Résidence Les Palmiers', 'adresse' => 'Avenue des Cocotiers', 'tel' => '+33 9 87 65 43 21', 'link' => '#'],
            ],
            'contact_mariage' => 'Margot (Wedding Planner)',
            'contact_tel' => '+33 6 11 22 33 44',
            'contact_email' => 'contact@mariage-maeva-gilles.fr',
        ];

        return view('pages.details-pratiques', $data);
    }
}