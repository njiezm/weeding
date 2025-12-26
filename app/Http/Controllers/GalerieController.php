<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Photo;

class GalerieController extends Controller
{
    public function index()
    {
        $photos = Photo::with('participant')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.galerie', compact('photos'));
    }

    public function store(Request $request)
        {
            $request->validate([
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'photo' => 'required|image|max:5120',
            ]);

            $participant = Participant::firstOrCreate([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
            ]);

            // Utiliser le disque "public" pour stocker les fichiers
            $path = $request->file('photo')->store('galerie', 'public');

            Photo::create([
                'participant_id' => $participant->id,
                'path' => $path,
            ]);

            return back()->with('success', 'Photo ajoutée 📸');
        }
}
