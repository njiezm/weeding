<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\JeuQuiDeux;

class JeuxController extends Controller
{
    public function quiDeux()
    {
    $questions = JeuQuiDeux::all();
    return view('jeux.qui2', compact('questions'));
    }


    public function submitQuiDeux(Request $request)
    {
    $request->validate([
    'nom' => 'required',
    'prenom' => 'required',
    'answers' => 'required|array'
    ]);


    $participant = Participant::firstOrCreate([
    'nom' => $request->nom,
    'prenom' => $request->prenom
    ]);


    foreach($request->answers as $index => $answer){
    $questionText = JeuQuiDeux::find($index+1)->question ?? 'Question '.$index;
    JeuQuiDeux::create([
    'participant_id' => $participant->id,
    'question' => $questionText,
    'reponse' => $answer
    ]);
    }

    return redirect('/home')->with('success', 'Merci d\'avoir participé !');
    }


    public function storeQuiDeux(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'question' => 'required',
            'reponse' => 'required',
        ]);

        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        JeuQuiDeux::create([
            'participant_id' => $participant->id,
            'question' => $request->question,
            'reponse' => $request->reponse,
        ]);

        return back()->with('success', 'Réponse enregistrée 🎉');
    }

    // Méthode pour la chasse au trésor photo
    public function chassePhoto()
    {
        return view('jeux.chasse-photo');
    }

    // Méthode pour soumettre la photo
    public function submitChassePhoto(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'indice' => 'required',
            'photo' => 'required|image|max:4096', // max 4MB
        ]);

        $participantName = $request->prenom . '_' . $request->nom;

        $path = $request->file('photo')->store('public/chasse-photos');

        // Enregistrer en base si tu veux, sinon juste stocker la photo
        // Exemple : Photo::create([...]);

        return back()->with('success', 'Photo envoyée avec succès !');
    }
}
