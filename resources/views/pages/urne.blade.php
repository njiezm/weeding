@extends('layout')

@section('content')

<h2 class="text-center urne-heading">
    Liste de Mariage & Urne 🎁
</h2>

<p class="text-center urne-intro col-md-8 mx-auto">
    Votre présence est notre plus beau cadeau. Pour ceux qui souhaitent contribuer à notre voyage de noces (ou autre grand projet !), nous avons mis en place un système simple et sécurisé.
</p>

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

        @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
        @endif

        <div class="contribution-card">
            <h4 class="text-center fw-bold mb-4" style="color:var(--vert-sapin);">
                Votre Contribution
            </h4>

            <form method="POST" action="{{ url('/urne/payer') }}" id="urne-form">
                @csrf

                <div class="row mb-3 g-2">
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="nom" placeholder="Votre nom" required>
                    </div>
                </div>

                <textarea class="form-control mb-4" name="message" rows="3"
                    placeholder="Un petit message pour les mariés (facultatif) 💖"></textarea>

                <label class="form-label fw-bold d-block text-center" style="color:var(--vert-sapin);">
                    Choisir un montant rapide :
                </label>
                <div class="amount-buttons">
                    <button type="button" class="btn btn-amount" data-amount="50">50 €</button>
                    <button type="button" class="btn btn-amount" data-amount="100">100 €</button>
                    <button type="button" class="btn btn-amount" data-amount="150">150 €</button>
                    <button type="button" class="btn btn-amount" data-amount="200">200 €</button>
                </div>
                
                <hr style="border-top: 1px dashed var(--vert-tres-clair);" class="my-3">

                <label for="montant-input" class="form-label fw-bold d-block text-center" style="color:var(--vert-sapin);">
                    Ou saisir le montant de votre choix :
                </label>
                <input type="number" id="montant-input" class="form-control input-montant mb-3"
                    name="montant" min="1" placeholder="00 €" required>

                <div class="payment-options-box text-center">
                    <span class="fw-bold d-block mb-2">Paiement sécurisé via :</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Visa_Logo.svg" alt="Visa" class="payment-option-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="payment-option-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_Pay_logo.svg" alt="Apple Pay" class="payment-option-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f2/Google_Pay_Logo.svg" alt="Google Pay" class="payment-option-logo">
                    <span class="d-block mt-2 text-muted" style="font-size:0.9rem;">(Carte bancaire, Apple/Google Pay, etc. via Stripe)</span>
                </div>
                
                <button type="submit" class="btn btn-payer w-100 mt-4">
                    <i class="fa-solid fa-credit-card me-2"></i> Procéder au paiement sécurisé
                </button>
            </form>

        </div>
        
        <div class="card mt-4 p-4 text-center border-0 shadow-sm" style="background-color: var(--vert-tres-clair);">
            <p class="fw-bold mb-1" style="color:var(--vert-sapin);">
                <i class="fa-solid fa-bank me-2"></i> Option Virement Bancaire
            </p>
            <p class="mb-0 text-muted" style="font-size:0.95rem;">
                Si vous préférez, vous pouvez effectuer un virement. <span class="fw-bold">Contactez-nous</span> pour obtenir notre IBAN.
            </p>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountButtons = document.querySelectorAll('.btn-amount');
    const montantInput = document.getElementById('montant-input');

    amountButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // 1. Désélectionner tous les boutons
            amountButtons.forEach(btn => btn.classList.remove('active'));
            
            // 2. Sélectionner le bouton cliqué
            this.classList.add('active');
            
            // 3. Mettre à jour le champ de saisie avec la valeur du bouton
            montantInput.value = this.dataset.amount;
        });
    });

    // 4. Désélectionner les boutons si l'utilisateur saisit manuellement
    montantInput.addEventListener('input', function() {
        amountButtons.forEach(btn => btn.classList.remove('active'));
    });
    
    // 5. Validation initiale: assurez-vous qu'un montant est présent au chargement
    // Si aucun montant n'est là, mettez le premier bouton actif comme valeur par défaut pour une meilleure UX.
    if (!montantInput.value) {
        amountButtons[0].click(); 
    }
});
</script>
@endsection