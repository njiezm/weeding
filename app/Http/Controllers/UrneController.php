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
            'prenom' => 'required',
            'nom' => 'required',
            'message' => 'nullable',
            'montant' => 'required|numeric|min:1'
        ]);

        $participant = Participant::firstOrCreate([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
        ]);

        $don = UrneDon::create([
            'participant_id' => $participant->id,
            'montant' => $request->montant,
            'moyen_paiement' => 'stripe',
            'statut' => 'en_attente',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Urne mariage 💍',
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
            ]
        ]);

        $don->update([
            'transaction_id' => $session->id
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return view('pages.urne-success');
    }

    public function cancel()
    {
        return view('pages.urne-cancel');
    }

    public function stripeWebhook(Request $request)
    {
        $event = \Stripe\Webhook::constructEvent(
            $request->getContent(),
            $request->header('Stripe-Signature'),
            config('services.stripe.webhook_secret')
        );

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $don = UrneDon::where('transaction_id', $session->id)->first();
            if ($don) {
                $don->update(['statut' => 'payé']);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
