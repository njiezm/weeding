@extends('layout')
@section('content')

<h2 class="text-center game-heading">
    <i class="fa-solid fa-puzzle-piece me-2"></i> Mots Croisés des Mariés
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
                {{ $motsCroises->titre }}
            </h4>
            
            @if($motsCroises->description)
            <p class="text-center mb-4">{{ $motsCroises->description }}</p>
            @endif

            <form method="POST" action="{{ route('jeux.submitMotsCroises') }}">
                @csrf
                <input type="hidden" name="session_jeu_id" value="{{ $sessionActive->id }}">
                <input type="hidden" name="mots_croises_id" value="{{ $motsCroises->id }}">

                <div class="row mb-4 g-3">
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" name="nom" placeholder="Votre nom" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Grille de mots croisés</h5>
                        <div class="crossword-grid">
                            @for($y = 0; $y < $motsCroises->taille; $y++)
                            <div class="crossword-row">
                                @for($x = 0; $x < $motsCroises->taille; $x++)
                                @php
                                    $isBlack = true;
                                    $motId = null;
                                    $letterNumber = null;
                                    
                                    foreach($motsCroises->mots as $mot) {
                                        if ($mot->direction === 'horizontal') {
                                            if ($y == $mot->position_y && $x >= $mot->position_x && $x < $mot->position_x + strlen($mot->mot)) {
                                                $isBlack = false;
                                                $motId = $mot->id;
                                                $letterNumber = $x - $mot->position_x + 1;
                                                break;
                                            }
                                        } else {
                                            if ($x == $mot->position_x && $y >= $mot->position_y && $y < $mot->position_y + strlen($mot->mot)) {
                                                $isBlack = false;
                                                $motId = $mot->id;
                                                $letterNumber = $y - $mot->position_y + 1;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if($isBlack)
                                <div class="crossword-cell black"></div>
                                @else
                                <div class="crossword-cell white">
                                    @if($letterNumber == 1)
                                    <span class="cell-number">{{ $motId }}</span>
                                    @endif
                                    <!-- NOUVEAU CODE -->
<input type="text" 
       class="cell-input" 
       maxlength="1" 
       name="grid[{{ $y }}][{{ $x }}]"
       data-x="{{ $x }}"
       data-y="{{ $y }}">
                                </div>
                                @endif
                                @endfor
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3">Définitions</h5>
                        <div class="definitions-container">
                            <div class="definitions-section">
                                <h6>Horizontalement</h6>
                                <ul class="list-unstyled">
                                    @foreach($motsCroises->mots->where('direction', 'horizontal')->sortBy('id') as $mot)
                                    <li><strong>{{ $mot->id }}.</strong> {{ $mot->definition }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="definitions-section">
                                <h6>Verticalement</h6>
                                <ul class="list-unstyled">
                                    @foreach($motsCroises->mots->where('direction', 'vertical')->sortBy('id') as $mot)
                                    <li><strong>{{ $mot->id }}.</strong> {{ $mot->definition }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-pro-primary btn-lg">
                        <i class="fa-solid fa-check-circle me-2"></i> Vérifier mes réponses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ... Vos styles CSS restent les mêmes ... */
.crossword-grid {
    /*display: inline-block;*/
    border: 2px solid #333;
    margin-bottom: 20px;
}

.crossword-row {
    display: flex;
}

.crossword-cell {
    width: 30px;
    /*height: 30px;*/
    border: 1px solid #ccc;
    position: relative;
}

.crossword-cell.black {
    background-color: #333;
}

.crossword-cell.white {
    background-color: white;
}

.cell-input {
    width: 100%;
    height: 100%;
    border: none;
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
    user-select: none;
}

.cell-number {
    position: absolute;
    top: 0;
    left: 2px;
    font-size: 10px;
    line-height: 1;
    pointer-events: none;
}

.definitions-container {
    max-height: 400px;
    overflow-y: auto;
}

.definitions-section {
    margin-bottom: 20px;
}
</style>

{{-- Script pour la navigation améliorée --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.cell-input');
    const gridSize = 12; // Assurez-vous que cela correspond à la taille de votre grille

    function findInput(x, y) {
        if (x < 0 || x >= gridSize || y < 0 || y >= gridSize) {
            return null;
        }
        return document.querySelector(`.cell-input[data-x="${x}"][data-y="${y}"]`);
    }

    inputs.forEach(input => {
        input.addEventListener('keydown', function(event) {
            let currentX = parseInt(this.dataset.x, 10);
            let currentY = parseInt(this.dataset.y, 10);
            let nextInput = null;

            switch (event.key) {
                case 'ArrowUp':
                    event.preventDefault();
                    nextInput = findInput(currentX, currentY - 1);
                    break;
                case 'ArrowDown':
                    event.preventDefault();
                    nextInput = findInput(currentX, currentY + 1);
                    break;
                case 'ArrowLeft':
                    event.preventDefault();
                    nextInput = findInput(currentX - 1, currentY);
                    break;
                case 'ArrowRight':
                    event.preventDefault();
                    nextInput = findInput(currentX + 1, currentY);
                    break;
                case 'Backspace':
                    // Si la case est vide, on recule
                    if (this.value === '') {
                        event.preventDefault();
                        nextInput = findInput(currentX - 1, currentY);
                        if (!nextInput) { // Si on est au début d'une ligne, on essaie la ligne précédente
                             nextInput = findInput(gridSize - 1, currentY - 1);
                        }
                    }
                    break;
                default:
                    // Pour les autres touches, on laisse le comportement par défaut
                    // Si la case est remplie, on avance à la droite
                    if (this.value.length === 1 && event.key !== 'Tab') {
                        nextInput = findInput(currentX + 1, currentY);
                        if (!nextInput) { // Si on est en fin de ligne, on passe à la ligne suivante
                            nextInput = findInput(0, currentY + 1);
                        }
                    }
                    break;
            }

            if (nextInput) {
                nextInput.focus();
            }
        });
    });
});
</script>

@endsection