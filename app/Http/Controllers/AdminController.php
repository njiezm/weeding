<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionQuiDeux;
use App\Models\SessionJeu;
use App\Models\ReponseQuiDeux;
use App\Models\EtapeCeremonie;
use App\Models\MotsCroises;
use App\Models\MotCroise;
use App\Models\MemoryCard;
use App\Models\QrCode;
use App\Models\QrCodeScan;
use App\Models\Participant;


class AdminController extends Controller
{
   public function dashboard()
{
    $sessions = SessionJeu::orderBy('created_at', 'desc')->get();
    $questions = QuestionQuiDeux::orderBy('created_at', 'desc')->get();
    $etapesCeremonie = EtapeCeremonie::orderBy('ordre')->get();
    
    // Compter les étapes en cours
    $etapesEnCours = EtapeCeremonie::where('en_cours', true)->count();
    
    // Compter les questions actives
    $questionsActives = QuestionQuiDeux::where('active', true)->count();
    
    // Compter les mots croisés
    $motsCroisesCount = MotsCroises::count();
    
    // Compter les cartes memory (paires)
    $memoryCardsCount = MemoryCard::count() / 2;
    
    // Compter les participants (à adapter selon votre modèle)
    //$participants = Participant::all();
    $participantsCount = Participant::count();

        // =====================================================
        // Nouvelles statistiques pour les QR Codes
    
     $qrCodesCount = QrCode::count();
        $totalScansCount = QrCodeScan::count();
        // =====================================================

        return view('admin.dashboard', compact(
            'sessions', 
            'questionsActives', 
            'etapesEnCours', 
            'participantsCount',
            'questions',
            'etapesCeremonie',
            'motsCroisesCount',
            'memoryCardsCount',
            // On ajoute les nouvelles variables à la liste
            'qrCodesCount',
            'totalScansCount'
        ));
    
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
        'type_jeu' => 'required|in:qui_deux,chasse_photo,mots_croises,memory,autre',
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
        'type_jeu' => 'required|in:qui_deux,chasse_photo,mots_croises,memory,autre',
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

            /**
         * Affiche la page de gestion des étapes de la cérémonie
         */
        public function etapesCeremonie()
        {
            $etapes = EtapeCeremonie::orderBy('ordre')->get();
            return view('admin.etapes-ceremonie', compact('etapes'));
        }

        /**
         * Stocke une nouvelle étape de cérémonie
         */
        public function storeEtapeCeremonie(Request $request)
        {
            $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icone' => 'nullable|string|max:50',
                'ordre' => 'required|integer|min:0',
            ]);

            EtapeCeremonie::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'icone' => $request->icone,
                'ordre' => $request->ordre,
            ]);

            return back()->with('success', 'Étape ajoutée avec succès !');
        }

        /**
         * Met à jour une étape de cérémonie
         */
        public function updateEtapeCeremonie(Request $request, EtapeCeremonie $etape)
        {
            $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icone' => 'nullable|string|max:50',
                'ordre' => 'required|integer|min:0',
            ]);

            $etape->update([
                'titre' => $request->titre,
                'description' => $request->description,
                'icone' => $request->icone,
                'ordre' => $request->ordre,
            ]);

            return back()->with('success', 'Étape mise à jour avec succès !');
        }

        /**
         * Supprime une étape de cérémonie
         */
        public function deleteEtapeCeremonie(EtapeCeremonie $etape)
        {
            $etape->delete();
            return back()->with('success', 'Étape supprimée avec succès !');
        }

        /**
         * Marque une étape comme étant en cours
         */
        public function marquerEnCours(EtapeCeremonie $etape)
        {
            // Désactiver toutes les autres étapes
            EtapeCeremonie::where('id', '!=', $etape->id)->update(['en_cours' => false]);
            
            // Marquer cette étape comme en cours
            $etape->update(['en_cours' => true]);
            
            return back()->with('success', 'Étape marquée comme en cours !');
        }

        /**
         * Marque une étape comme terminée
         */
        public function marquerTermine(EtapeCeremonie $etape)
        {
            $etape->update(['termine' => true, 'en_cours' => false]);
            
            return back()->with('success', 'Étape marquée comme terminée !');
        }

        /**
         * Marque une étape comme non terminée
         */
        public function marquerNonTermine(EtapeCeremonie $etape)
        {
            $etape->update(['termine' => false]);
            
            return back()->with('success', 'Étape marquée comme non terminée !');
        }

        // Gestion des mots croisés
    public function motsCroises()
    {
        $motsCroises = MotsCroises::with('mots')->orderBy('created_at', 'desc')->get();
        return view('admin.mots-croises', compact('motsCroises'));
    }

    public function storeMotsCroises(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'taille' => 'required|integer|min:5|max:20',
        ]);

        $motsCroises = MotsCroises::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'taille' => $request->taille,
        ]);

        return redirect()->route('admin.editMotsCroises', $motsCroises->id)
            ->with('success', 'Mots croisés créés avec succès ! Ajoutez maintenant les mots.');
    }

    public function editMotsCroises(MotsCroises $motsCroises)
    {
        $motsCroises->load('mots');
        return view('admin.edit-mots-croises', compact('motsCroises'));
    }

    public function updateMotsCroises(Request $request, MotsCroises $motsCroises)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'taille' => 'required|integer|min:5|max:20',
            'actif' => 'boolean',
        ]);

        $motsCroises->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'taille' => $request->taille,
            'actif' => $request->has('actif'),
        ]);

        return back()->with('success', 'Mots croisés mis à jour avec succès !');
    }

    public function storeMot(Request $request, MotsCroises $motsCroises)
{
    $request->validate([
        'mot' => 'required|string|max:255',
        'definition' => 'required|string',
        'position_x' => 'required|integer|min:0',
        'position_y' => 'required|integer|min:0',
        'direction' => 'required|in:horizontal,vertical',
    ]);

    MotCroise::create([  // Utilisez MotCroise ici
        'mots_croise_id' => $motsCroises->id,
        'mot' => $request->mot,
        'definition' => $request->definition,
        'position_x' => $request->position_x,
        'position_y' => $request->position_y,
        'direction' => $request->direction,
    ]);

    return back()->with('success', 'Mot ajouté avec succès !');
}
    public function updateMot(Request $request, MotCroise $mot)  // Utilisez MotCroise ici
{
    $request->validate([
        'mot' => 'required|string|max:255',
        'definition' => 'required|string',
        'position_x' => 'required|integer|min:0',
        'position_y' => 'required|integer|min:0',
        'direction' => 'required|in:horizontal,vertical',
    ]);

    $mot->update([
        'mot' => $request->mot,
        'definition' => $request->definition,
        'position_x' => $request->position_x,
        'position_y' => $request->position_y,
        'direction' => $request->direction,
    ]);

    return back()->with('success', 'Mot mis à jour avec succès !');
}

    public function deleteMot(MotCroise $mot)  // Utilisez MotCroise ici
    {
        $mot->delete();
        return back()->with('success', 'Mot supprimé avec succès !');
    }
        

    // Gestion des cartes memory
    public function memoryCards()
    {
        $cards = MemoryCard::orderBy('pair_id')->get();
        return view('admin.memory-cards', compact('cards'));
    }

    public function storeMemoryCard(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'pair_id' => 'required|string|max:255',
        ]);

        $path = $request->file('image')->store('public/memory-cards');
        
        MemoryCard::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'image_path' => $path,
            'pair_id' => $request->pair_id,
        ]);

        return back()->with('success', 'Carte ajoutée avec succès !');
    }

    public function updateMemoryCard(Request $request, MemoryCard $card)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pair_id' => 'required|string|max:255',
            'actif' => 'boolean',
        ]);

        $card->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'pair_id' => $request->pair_id,
            'actif' => $request->has('actif'),
        ]);

        // Si une nouvelle image est fournie
        if ($request->hasFile('image')) {
            $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096']);
            $path = $request->file('image')->store('public/memory-cards');
            $card->update(['image_path' => $path]);
        }

        return back()->with('success', 'Carte mise à jour avec succès !');
    }

    public function deleteMemoryCard(MemoryCard $card)
    {
        $card->delete();
        return back()->with('success', 'Carte supprimée avec succès !');
    }

    // ... (vos méthodes existantes)

// === GESTION DES LECTURES ===
public function lectures()
{
    $lectures = Lecture::orderBy('ordre')->get();
    return view('admin.lectures', compact('lectures'));
}

public function storeLecture(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'reference' => 'required|string',
        'contenu' => 'required|string',
        'auteur' => 'nullable|string|max:255',
        'ordre' => 'required|integer|min:0',
    ]);

    Lecture::create($request->all());

    return back()->with('success', 'Lecture ajoutée avec succès !');
}

public function updateLecture(Request $request, Lecture $lecture)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'reference' => 'required|string',
        'contenu' => 'required|string',
        'auteur' => 'nullable|string|max:255',
        'ordre' => 'required|integer|min:0',
    ]);

    $lecture->update($request->all());

    return back()->with('success', 'Lecture mise à jour avec succès !');
}

public function deleteLecture(Lecture $lecture)
{
    $lecture->delete();
    return back()->with('success', 'Lecture supprimée avec succès !');
}

// === GESTION DES CHANTS ===
public function chants()
{
    $chants = Chant::orderBy('ordre')->get();
    return view('admin.chants', compact('chants'));
}

public function storeChant(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'paroles' => 'required|string',
        'auteur' => 'nullable|string|max:255',
        'ordre' => 'required|integer|min:0',
    ]);

    Chant::create($request->all());

    return back()->with('success', 'Chant ajouté avec succès !');
}

// ... (méthodes updateChant et deleteChant similaires)

// === GESTION DES PRIÈRES ===
public function prieres()
{
    $prieres = Priere::orderBy('ordre')->get();
    return view('admin.prieres', compact('prieres'));
}

public function storePriere(Request $request)
{
    // ... (validation et création)
}

// ... (méthodes updatePriere et deletePriere similaires)

// === GESTION DES REMERCIEMENTS ===
public function remerciements()
{
    $remerciement = Remerciement::firstOrNew();
    return view('admin.remerciements', compact('remerciement'));
}

public function updateRemerciements(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'contenu' => 'required|string',
        'signatures' => 'nullable|string|max:255',
    ]);

    $remerciement = Remerciement::firstOrCreate([]);
    $remerciement->update($request->all());

    return back()->with('success', 'Remerciements mis à jour avec succès !');
}
}