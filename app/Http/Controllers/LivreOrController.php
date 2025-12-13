<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\LivreOr;

class LivreOrController extends Controller
{
    public function index()
    {
        $messages = LivreOr::with('participant')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.livre-or', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
        ]);

        // Identification légère
        $participant = Participant::firstOrCreate([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        LivreOr::create([
            'participant_id' => $participant->id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Merci pour votre message ❤️');
    }
}
