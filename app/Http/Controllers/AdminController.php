<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionQuiDeux;
use App\Models\SessionJeu;
use App\Models\ReponseQuiDeux;

class AdminController extends Controller
{
    public function dashboard()
    {
        $sessions = SessionJeu::orderBy('created_at', 'desc')->get();
        $questions = QuestionQuiDeux::orderBy('created_at', 'desc')->get();
        
        return view('admin.dashboard', compact('sessions', 'questions'));
    }

    // Gestion des questions
    public function questions()
    {
        $questions = QuestionQuiDeux::orderBy('created_at', 'desc')->get();
        return view('admin.questions', compact('questions'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'bonne_reponse' => 'required|in:Gilles,Maëva',
        ]);

        QuestionQuiDeux::create([
            'question' => $request->question,
            'bonne_reponse' => $request->bonne_reponse,
        ]);

        return back()->with('success', 'Question ajoutée avec succès !');
    }

    public function updateQuestion(Request $request, QuestionQuiDeux $question)
    {
        $request->validate([
            'question' => 'required|string',
            'bonne_reponse' => 'required|in:Gilles,Maëva',
            'active' => 'boolean',
        ]);

        $question->update([
            'question' => $request->question,
            'bonne_reponse' => $request->bonne_reponse,
            'active' => $request->has('active'),
        ]);

        return back()->with('success', 'Question mise à jour avec succès !');
    }

    public function deleteQuestion(QuestionQuiDeux $question)
    {
        $question->delete();
        return back()->with('success', 'Question supprimée avec succès !');
    }

    // Gestion des sessions de jeu
    public function sessions()
    {
        $sessions = SessionJeu::orderBy('created_at', 'desc')->get();
        return view('admin.sessions', compact('sessions'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'type_jeu' => 'required|in:qui_deux,chasse_photo,autre',
        ]);

        SessionJeu::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_jeu' => $request->type_jeu,
        ]);

        return back()->with('success', 'Session créée avec succès !');
    }

    public function updateSession(Request $request, SessionJeu $session)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'type_jeu' => 'required|in:qui_deux,chasse_photo,autre',
        ]);

        $session->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_jeu' => $request->type_jeu,
        ]);

        return back()->with('success', 'Session mise à jour avec succès !');
    }

    public function lancerSession(SessionJeu $session)
    {
        // Désactiver toutes les autres sessions du même type
        SessionJeu::where('type_jeu', $session->type_jeu)->where('id', '!=', $session->id)->update(['actif' => false]);
        
        // Activer cette session
        $session->update([
            'actif' => true,
            'debut' => now(),
        ]);

        return back()->with('success', 'Session lancée avec succès !');
    }

    public function arreterSession(SessionJeu $session)
    {
        $session->update([
            'actif' => false,
            'fin' => now(),
        ]);

        return back()->with('success', 'Session arrêtée avec succès !');
    }

    // Résultats
    public function resultats(SessionJeu $session)
    {
        $reponses = ReponseQuiDeux::where('session_jeu_id', $session->id)
            ->with(['participant', 'question'])
            ->get()
            ->groupBy('participant_id');
            
        $scores = [];
        foreach ($reponses as $participantId => $reponsesParticipant) {
            $participant = $reponsesParticipant->first()->participant;
            $score = $reponsesParticipant->where('correct', true)->count();
            $total = $reponsesParticipant->count();
            
            $scores[] = [
                'participant' => $participant,
                'score' => $score,
                'total' => $total,
                'pourcentage' => $total > 0 ? round(($score / $total) * 100, 1) : 0
            ];
        }
        
        // Trier par score décroissant
        usort($scores, function($a, $b) {
            return $b['score'] - $a['score'];
        });
        
        return view('admin.resultats', compact('session', 'scores'));
    }

    /**
     * Affiche les soumissions de la chasse photo pour une session.
     */
    public function chassePhotosSubmissions(SessionJeu $session)
    {
        // Récupère les photos avec les infos des participants
        $submissions = $session->chassePhotos()->with('participant')->orderBy('created_at', 'desc')->get();
        
        return view('admin.chasse-photos-submissions', compact('session', 'submissions'));
    }

    /**
     * Valide ou invalide une photo soumise.
     */
    public function validateChassePhoto(ChassePhoto $chassePhoto)
    {
        $chassePhoto->update(['valide' => !$chassePhoto->valide]);
        
        $status = $chassePhoto->valide ? 'validée' : 'invalidée';
        return back()->with('success', "La photo a été {$status} avec succès !");
    }
}