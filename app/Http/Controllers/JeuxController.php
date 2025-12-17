<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\QuestionQuiDeux;
use App\Models\ReponseQuiDeux;
use App\Models\SessionJeu;

class JeuxController extends Controller
{
    public function quiDeux()
    {
        // Vérifier s'il y a une session active
        $sessionActive = SessionJeu::where('type_jeu', 'qui_deux')->where('actif', true)->first();
        
        if (!$sessionActive) {
            return view('jeux.en-attente', [
                'message' => 'Le jeu "Qui de nous deux ?" n\'est pas encore lancé. Revenez plus tard !'
            ]);
        }
        
        $questions = QuestionQuiDeux::where('active', true)->get();
        
        return view('jeux.qui2', compact('questions', 'sessionActive'));
    }

    public function submitQuiDeux(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'answers' => 'required|array',
            'session_jeu_id' => 'required|exists:sessions_jeu,id'
        ]);

        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);

        $sessionJeu = SessionJeu::find($request->session_jeu_id);
        
        $score = 0;
        $total = 0;

        foreach ($request->answers as $questionId => $answer) {
            $question = QuestionQuiDeux::find($questionId);
            
            if ($question) {
                $correct = ($answer === $question->bonne_reponse);
                if ($correct) $score++;
                $total++;
                
                ReponseQuiDeux::create([
                    'participant_id' => $participant->id,
                    'question_id' => $questionId,
                    'reponse' => $answer,
                    'correct' => $correct,
                    'session_jeu_id' => $sessionJeu->id
                ]);
            }
        }

        $pourcentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;
        
        return redirect()->route('jeux.resultats', ['session' => $sessionJeu->id])
            ->with('success', "Merci d'avoir participé ! Votre score : $score/$total ($pourcentage%)");
    }

    public function resultats(SessionJeu $session)
    {
        $participantId = session('participant_id');
        
        if (!$participantId) {
            return redirect()->route('jeux.quiDeux')->with('error', 'Vous devez d\'abord participer au jeu pour voir les résultats.');
        }
        
        $reponses = ReponseQuiDeux::where('participant_id', $participantId)
            ->where('session_jeu_id', $session->id)
            ->with('question')
            ->get();
            
        $score = $reponses->where('correct', true)->count();
        $total = $reponses->count();
        $pourcentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;
        
        return view('jeux.resultats', compact('reponses', 'score', 'total', 'pourcentage', 'session'));
    }

    // Méthode pour la chasse au trésor photo
    public function chassePhoto()
    {
        // Vérifier s'il y a une session active
        $sessionActive = SessionJeu::where('type_jeu', 'chasse_photo')->where('actif', true)->first();
        
        if (!$sessionActive) {
            return view('jeux.en-attente', [
                'message' => 'La chasse au trésor photo n\'est pas encore lancée. Revenez plus tard !'
            ]);
        }
        
        return view('jeux.chasse-photo', compact('sessionActive'));
    }

    // Méthode pour soumettre la photo
    public function submitChassePhotoold(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'indice' => 'required',
            'photo' => 'required|image|max:4096', // max 4MB
            'session_jeu_id' => 'required|exists:sessions_jeu,id'
        ]);

        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);

        $sessionJeu = SessionJeu::find($request->session_jeu_id);
        
        $path = $request->file('photo')->store('public/chasse-photos');

        // Ici, vous pourriez enregistrer la photo dans une table dédiée si nécessaire

        return back()->with('success', 'Photo envoyée avec succès !');
    }

    public function chassePhotos()
{
    return $this->hasMany(ChassePhoto::class, 'session_jeu_id');
}

public function submitChassePhoto(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'indice' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // max 4MB
            'session_jeu_id' => 'required|exists:sessions_jeu,id'
        ]);

        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);

        $sessionJeu = SessionJeu::find($request->session_jeu_id);
        
        // Gérer le téléchargement du fichier
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/chasse-photos');
            
            ChassePhoto::create([
                'participant_id' => $participant->id,
                'session_jeu_id' => $sessionJeu->id,
                'indice' => $request->indice,
                'photo_path' => $path,
            ]);
        }

        return back()->with('success', 'Photo envoyée avec succès ! Elle est en attente de validation.');
    }

}