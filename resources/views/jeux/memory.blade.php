@extends('layout')
@section('content')

<h2 class="text-center game-heading">
    <i class="fa-solid fa-brain me-2"></i> Memory des Mariés
</h2>

<div class="row justify-content-center">
    <div class="col-lg-10">

        @if(session('success'))
        <div class="alert alert-success text-center">
        {{ session('success') }}
        </div>
        @endif

        <div class="game-card">
            <h4 class="text-center mb-4 fw-bold" style="color:var(--vert-sapin); font-family:var(--font-pro);">
                Retrouvez les paires de photos des mariés !
            </h4>

            <form method="POST" action="{{ route('jeux.submitMemory') }}" id="memoryForm">
                @csrf
                <input type="hidden" name="session_jeu_id" value="{{ $sessionActive->id }}">

                <div class="row mb-4 g-3">
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="nom" placeholder="Votre nom" required>
                    </div>
                </div>

                <div class="memory-game-info text-center mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fa-solid fa-hand-pointer"></i>
                                <span>Coups : <span id="coups">0</span></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fa-solid fa-clock"></i>
                                <span>Temps : <span id="temps">00:00</span></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fa-solid fa-trophy"></i>
                                <span>Paires trouvées : <span id="paires">0</span>/{{ $shuffledCards->count() / 2 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="memory-board">
                    @foreach($shuffledCards as $index => $card)
                    <div class="memory-card" data-card-id="{{ $card->id }}" data-pair-id="{{ $card->pair_id }}">
                        <div class="memory-card-inner">
                            <div class="memory-card-front">
                                <img src="{{ asset('images/memory-back.jpg') }}" alt="Carte mémoire">
                            </div>
                            <div class="memory-card-back">
                                <img src="{{ $card->image_url }}" alt="{{ $card->titre }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <input type="hidden" name="coups" id="coupsInput" value="0">
                <input type="hidden" name="temps" id="tempsInput" value="0">

                <div class="text-center mt-4">
                    <button type="button" id="restartBtn" class="btn btn-secondary btn-lg me-2">
                        <i class="fa-solid fa-redo me-2"></i> Recommencer
                    </button>
                    <button type="submit" class="btn btn-pro-primary btn-lg" id="submitBtn" disabled>
                        <i class="fa-solid fa-check-circle me-2"></i> Terminer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.memory-board {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.memory-card {
    aspect-ratio: 1/1;
    cursor: pointer;
    perspective: 1000px;
}

.memory-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.6s;
    transform-style: preserve-3d;
}

.memory-card.flipped .memory-card-inner {
    transform: rotateY(180deg);
}

.memory-card-front, .memory-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    border-radius: 8px;
    overflow: hidden;
}

.memory-card-front img, .memory-card-back img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.memory-card-back {
    transform: rotateY(180deg);
}

.memory-card.matched {
    opacity: 0.7;
    cursor: default;
}

.info-box {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
}

.info-box i {
    margin-right: 5px;
    color: var(--vert-sapin);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.memory-card');
    const coupsElement = document.getElementById('coups');
    const tempsElement = document.getElementById('temps');
    const pairesElement = document.getElementById('paires');
    const coupsInput = document.getElementById('coupsInput');
    const tempsInput = document.getElementById('tempsInput');
    const submitBtn = document.getElementById('submitBtn');
    const restartBtn = document.getElementById('restartBtn');
    
    let hasFlippedCard = false;
    let lockBoard = false;
    let firstCard, secondCard;
    let coups = 0;
    let pairesTrouvees = 0;
    let startTime = null;
    let timerInterval = null;
    
    function flipCard() {
        if (lockBoard) return;
        if (this === firstCard) return;
        
        // Démarrer le timer au premier clic
        if (!startTime) {
            startTime = Date.now();
            timerInterval = setInterval(updateTimer, 1000);
        }
        
        this.classList.add('flipped');
        
        if (!hasFlippedCard) {
            // Premier clic
            hasFlippedCard = true;
            firstCard = this;
            return;
        }
        
        // Deuxième clic
        secondCard = this;
        checkForMatch();
    }
    
    function checkForMatch() {
        coups++;
        coupsElement.textContent = coups;
        coupsInput.value = coups;
        
        let isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;
        
        if (isMatch) {
            disableCards();
            pairesTrouvees++;
            pairesElement.textContent = pairesTrouvees;
            
            // Vérifier si toutes les paires ont été trouvées
            if (pairesTrouvees === cards.length / 2) {
                clearInterval(timerInterval);
                submitBtn.disabled = false;
            }
        } else {
            unflipCards();
        }
    }
    
    function disableCards() {
        firstCard.classList.add('matched');
        secondCard.classList.add('matched');
        firstCard.removeEventListener('click', flipCard);
        secondCard.removeEventListener('click', flipCard);
        resetBoard();
    }
    
    function unflipCards() {
        lockBoard = true;
        
        setTimeout(() => {
            firstCard.classList.remove('flipped');
            secondCard.classList.remove('flipped');
            resetBoard();
        }, 1000);
    }
    
    function resetBoard() {
        [hasFlippedCard, lockBoard] = [false, false];
        [firstCard, secondCard] = [null, null];
    }
    
    function updateTimer() {
        if (!startTime) return;
        
        const elapsed = Math.floor((Date.now() - startTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        
        tempsElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        tempsInput.value = elapsed;
    }
    
    function restartGame() {
        // Réinitialiser les variables
        coups = 0;
        pairesTrouvees = 0;
        startTime = null;
        
        // Mettre à jour l'affichage
        coupsElement.textContent = '0';
        tempsElement.textContent = '00:00';
        pairesElement.textContent = '0';
        coupsInput.value = '0';
        tempsInput.value = '0';
        
        // Réinitialiser les cartes
        cards.forEach(card => {
            card.classList.remove('flipped', 'matched');
            card.addEventListener('click', flipCard);
        });
        
        // Réinitialiser le tableau
        resetBoard();
        
        // Arrêter le timer
        clearInterval(timerInterval);
        
        // Désactiver le bouton de soumission
        submitBtn.disabled = true;
    }
    
    // Ajouter les écouteurs d'événements
    cards.forEach(card => card.addEventListener('click', flipCard));
    restartBtn.addEventListener('click', restartGame);
});
</script>

@endsection