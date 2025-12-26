<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\QuestionQuiDeux;
use App\Models\ReponseQuiDeux;
use App\Models\SessionJeu;
use App\Models\MotsCroises;
use App\Models\Mot;
use App\Models\MemoryCard;

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

    public function motsCroises()
    {
        // Vérifier s'il y a une session active pour les mots croisés
        $sessionActive = SessionJeu::where('type_jeu', 'mots_croises')->where('actif', true)->first();
        
        if (!$sessionActive) {
            return view('jeux.en-attente', [
                'message' => 'Le jeu de mots croisés n\'est pas encore lancé. Revenez plus tard !'
            ]);
        }
        
        $motsCroises = MotsCroises::where('actif', true)->with('mots')->first();
        
        if (!$motsCroises) {
            return view('jeux.en-attente', [
                'message' => 'Aucun mots croisés disponible pour le moment.'
            ]);
        }
        
        return view('jeux.mots-croises', compact('motsCroises', 'sessionActive'));
    }

   public function submitMotsCroises(Request $request)
{
    $request->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'grid' => 'required|array', // On valide la grille
        'session_jeu_id' => 'required|exists:sessions_jeu,id'
    ]);

    $participant = Participant::firstOrCreate([
        'nom' => $request->nom,
        'prenom' => $request->prenom
    ]);

    $motsCroises = MotsCroises::find($request->mots_croises_id);
    
    if (!$motsCroises) {
        return back()->with('error', 'Grille de mots croisés non trouvée.');
    }
    
    $mots = $motsCroises->mots;
    $userGrid = $request->grid; // La grille remplie par l'utilisateur

    $score = 0;
    $total = $mots->count();

    // On parcourt chaque mot défini dans la BDD pour le vérifier
    foreach ($mots as $mot) {
        $userWord = ''; // Le mot reconstruit depuis la grille de l'utilisateur

        if ($mot->direction === 'horizontal') {
            // On récupère les lettres horizontalement
            for ($i = 0; $i < strlen($mot->mot); $i++) {
                $x = $mot->position_x + $i;
                $y = $mot->position_y;
                // On vérifie si la lettre existe dans la grille de l'utilisateur
                $userWord .= $userGrid[$y][$x] ?? '';
            }
        } else { // vertical
            // On récupère les lettres verticalement
            for ($i = 0; $i < strlen($mot->mot); $i++) {
                $x = $mot->position_x;
                $y = $mot->position_y + $i;
                // On vérifie si la lettre existe dans la grille de l'utilisateur
                $userWord .= $userGrid[$y][$x] ?? '';
            }
        }
        
        // On compare le mot reconstruit avec le mot correct
        if (strtolower(trim($userWord)) === strtolower($mot->mot)) {
            $score++;
        }
    }

    $pourcentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;
    
    return redirect()->route('jeux.resultatsMotsCroises')
        ->with('success', "Merci d'avoir participé ! Votre score : $score/$total ($pourcentage%)")
        ->with('score', $score)
        ->with('total', $total)
        ->with('pourcentage', $pourcentage);
}

    // Méthode pour afficher les résultats des mots croisés
    public function resultatsMotsCroises()
    {
        $score = session('score', 0);
        $total = session('total', 0);
        $pourcentage = session('pourcentage', 0);
        
        return view('jeux.resultats-mots-croises', compact('score', 'total', 'pourcentage'));
    }

    // Méthode pour le jeu de memory
    public function memory()
    {
        // Vérifier s'il y a une session active pour le memory
        $sessionActive = SessionJeu::where('type_jeu', 'memory')->where('actif', true)->first();
        
        if (!$sessionActive) {
            return view('jeux.en-attente', [
                'message' => 'Le jeu de memory n\'est pas encore lancé. Revenez plus tard !'
            ]);
        }
        
        $cards = MemoryCard::where('actif', true)->get();
        
        if ($cards->count() < 2) {
            return view('jeux.en-attente', [
                'message' => 'Pas assez de cartes pour le jeu de memory.'
            ]);
        }
        
        // Mélanger les cartes
        $shuffledCards = $cards->shuffle();
        
        return view('jeux.memory', compact('shuffledCards', 'sessionActive'));
    }

    // Méthode pour soumettre le score du memory
    public function submitMemory(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'coups' => 'required|integer|min:1',
            'session_jeu_id' => 'required|exists:sessions_jeu,id'
        ]);

        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);

        // Ici, vous pourriez stocker le score dans une table dédiée si nécessaire
        // Pour l'instant, nous allons simplement afficher le résultat
        
        $coups = $request->coups;
        $temps = $request->temps; // en secondes
        
        return redirect()->route('jeux.resultatsMemory')
            ->with('success', "Merci d'avoir participé ! Vous avez terminé en $coups coups.")
            ->with('coups', $coups)
            ->with('temps', $temps);
    }

    // Méthode pour afficher les résultats du memory
    public function resultatsMemory()
    {
        $coups = session('coups', 0);
        $temps = session('temps', 0);
        
        return view('jeux.resultats-memory', compact('coups', 'temps'));
    }
}

