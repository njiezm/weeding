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
                                    <input type="text" class="cell-input" maxlength="1" name="reponses[{{ $motId }}][{{ $letterNumber - 1 }}]">
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
                                    @foreach($motsCroises->mots->where('direction', 'horizontal') as $mot)
                                    <li><strong>{{ $mot->id }}.</strong> {{ $mot->definition }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="definitions-section">
                                <h6>Verticalement</h6>
                                <ul class="list-unstyled">
                                    @foreach($motsCroises->mots->where('direction', 'vertical') as $mot)
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
.crossword-grid {
    display: inline-block;
    border: 2px solid #333;
    margin-bottom: 20px;
}

.crossword-row {
    display: flex;
}

.crossword-cell {
    width: 30px;
    height: 30px;
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
}

.cell-number {
    position: absolute;
    top: 0;
    left: 2px;
    font-size: 10px;
    line-height: 1;
}

.definitions-container {
    max-height: 400px;
    overflow-y: auto;
}

.definitions-section {
    margin-bottom: 20px;
}
</style>

@endsection