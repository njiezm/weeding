@extends('layout')
@section('content')

<h2 class="text-center game-heading">
    <i class="fa-solid fa-puzzle-piece me-2"></i> Qui de nous deux ?
</h2>

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

        @if(session('success'))
        <div class="alert alert-success text-center">
        {{ session('success') }}
        </div>
        @endif

        <form method="POST" class="game-card">
            @csrf
            
            <h4 class="text-center mb-4 fw-bold" style="color:var(--vert-sapin); font-family:var(--font-pro);">
                Testez vos connaissances sur les mariés !
            </h4>

            <div class="row mb-4 g-3">
                <div class="col-md-6">
                    <input class="form-control form-control-lg" name="prenom" placeholder="Votre prénom" required>
                </div>
                <div class="col-md-6">
                    <input class="form-control form-control-lg" name="nom" placeholder="Votre nom" required>
                </div>
            </div>

            <div id="qui2Carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                <div class="carousel-inner">
                    @foreach($questions as $index => $question)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="question-content">
                            <h5><i class="fa-solid fa-question-circle me-2 text-dore-accent"></i> {{ $question->question }}</h5>
                            
                            <div class="answer-options mt-4">
                                
                                <input type="radio" id="gilles_{{ $index }}" name="answers[{{ $index }}]" value="Gilles" required>
                                <label for="gilles_{{ $index }}">
                                    Gilles
                                </label>
                                
                                <input type="radio" id="maeva_{{ $index }}" name="answers[{{ $index }}]" value="Maëva" required>
                                <label for="maeva_{{ $index }}">
                                    Maëva
                                </label>
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="quiz-navigation">
                    <button class="carousel-control-wedding" type="button" data-bs-target="#qui2Carousel" data-bs-slide="prev">
                        <i class="fa-solid fa-chevron-left me-1"></i> Précédent
                    </button>
                    
                    <button class="carousel-control-wedding next-btn" type="button" data-bs-target="#qui2Carousel" data-bs-slide="next">
                        Suivant <i class="fa-solid fa-chevron-right ms-1"></i>
                    </button>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-pro-primary btn-lg w-75 d-none submit-btn">
                        <i class="fa-solid fa-check-circle me-2"></i> Soumettre mes réponses
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('qui2Carousel');
    const submitBtn = document.querySelector('.submit-btn');
    const nextBtn = document.querySelector('.next-btn');
    const totalItems = document.querySelectorAll('.carousel-inner .carousel-item').length;

    function checkSlide() {
        // Index de la slide active (0-indexed)
        const activeItem = carousel.querySelector('.carousel-item.active');
        const activeIndex = Array.from(carousel.querySelectorAll('.carousel-inner .carousel-item')).indexOf(activeItem);

        if (activeIndex === totalItems - 1) {
            // Dernière slide : Afficher Soumettre, cacher Suivant
            submitBtn.classList.remove('d-none');
            nextBtn.classList.add('d-none');
            nextBtn.parentElement.querySelector('button[data-bs-slide="next"]').classList.add('d-none'); // Cache le bouton dans la nav
        } else {
            // Autres slides : Cacher Soumettre, afficher Suivant
            submitBtn.classList.add('d-none');
            nextBtn.classList.remove('d-none');
            nextBtn.parentElement.querySelector('button[data-bs-slide="next"]').classList.remove('d-none');
        }
    }

    // Écoute les événements de transition du carrousel
    carousel.addEventListener('slid.bs.carousel', checkSlide);

    // Vérifie au chargement initial
    checkSlide();
});
</script>

@endsection