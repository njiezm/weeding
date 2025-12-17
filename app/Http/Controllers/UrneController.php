<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\UrneDon;

class UrneController extends Controller
{
    public function index()
    {
        return view('pages.urne');
    }

    public function payer(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'montant' => 'required|numeric|min:1'
        ]);

        // Créer ou récupérer le participant
        $participant = Participant::firstOrCreate([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
        ]);

        // Créer le don avec le message
        $don = UrneDon::create([
            'participant_id' => $participant->id,
            'montant' => $request->montant,
            'message' => $request->message,
            'moyen_paiement' => 'stripe',
            'statut' => 'en_attente',
        ]);

        // Configuration de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Créer la session de paiement Stripe
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Urne mariage 💍',
                            'description' => $request->message ? 'Message: ' . substr($request->message, 0, 100) : null,
                        ],
                        'unit_amount' => $don->montant * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('urne.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('urne.cancel'),
                'metadata' => [
                    'don_id' => $don->id
                ],
                'customer_email' => $participant->email ?? null,
            ]);

            // Mettre à jour le don avec l'ID de transaction
            $don->update([
                'transaction_id' => $session->id
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            // En cas d'erreur, supprimer le don et afficher un message
            $don->delete();
            return back()->with('error', 'Une erreur est survenue lors de la préparation du paiement. Veuillez réessayer.');
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if ($sessionId) {
            // Vérifier si le paiement a été complété
            Stripe::setApiKey(config('services.stripe.secret'));
            
            try {
                $session = StripeSession::retrieve($sessionId);
                
                if ($session->payment_status === 'paid') {
                    // Mettre à jour le statut du don
                    $don = UrneDon::where('transaction_id', $sessionId)->first();
                    if ($don && $don->statut !== 'payé') {
                        $don->update(['statut' => 'payé']);
                    }
                    
                    return view('pages.urne-success', [
                        'montant' => $don ? $don->montant : null,
                        'message' => $don ? $don->message : null
                    ]);
                }
            } catch (\Exception $e) {
                // Gérer l'erreur
            }
        }
        
        return view('pages.urne-success');
    }

    public function cancel()
    {
        return view('pages.urne-cancel');
    }

    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');
        
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            $don = UrneDon::where('transaction_id', $session->id)->first();
            if ($don) {
                $don->update(['statut' => 'payé']);
                
                // Optionnel: envoyer un email de confirmation
                // Mail::to($don->participant->email)->send(new DonationConfirmation($don));
            }
        }

        return response()->json(['status' => 'ok']);
    }
}