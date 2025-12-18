@extends('layout')
@section('content')

<h2 class="text-center ceremony-heading">
    Cérémonie Religieuse 💍
</h2>

<div class="row">
    <div class="col-lg-8 mx-auto">

        <div class="status-banner-live text-center">
            <i class="fa-solid fa-signal me-2"></i> 
            <span class="fw-bold">STATUT EN DIRECT :</span> Nous sommes actuellement à l'étape : 
            <span class="current-step">
                @php
                    $etapeEnCours = App\Models\EtapeCeremonie::where('en_cours', true)->first();
                    echo $etapeEnCours ? $etapeEnCours->titre : 'En attente de début';
                @endphp
            </span>
        </div>

        <div class="location-card text-center mb-5">
            <h4 class="fw-bold" style="color:var(--vert-sapin);">Église Sainte-Trinité du Bonheur</h4>
            <p class="mb-1"><i class="fa-solid fa-clock me-2 text-dore-accent"></i> **Heure d'arrivée des invités :** 14h30</p>
            <p><i class="fa-solid fa-bell me-2 text-dore-accent"></i> **Début Précis de la Cérémonie :** 15h00</p>
            <p class="mt-3">
                <i class="fa-solid fa-map-pin me-2 text-dore-accent"></i> Adresse : 12 Rue de l'Amour Éternel, 97220 Le Paradis.
                <a href="#" class="btn btn-sm ms-3" style="background-color: var(--vert-sapin); color: var(--champagne-clair);">Voir sur la carte</a>
            </p>
        </div>
        
        <h3 class="fw-bold text-center mb-4" style="color:#e8e8e8; font-family:var(--font-pro);">
            Le Livret de Cérémonie Digital
        </h3>

        <div class="accordion ceremony-accordion" id="ceremonyAccordion">
            @php
                $etapes = App\Models\EtapeCeremonie::orderBy('ordre')->get();
            @endphp
            
            @foreach($etapes as $index => $etape)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ !$etape->en_cours ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $etape->id }}">
                        @if($etape->icone)
                            <i class="{{ $etape->icone }} me-3"></i>
                        @endif
                        {{ $index + 1 }}. {{ $etape->titre }}
                        
                        @if($etape->en_cours)
                            <span class="badge bg-primary ms-2">En cours</span>
                        @elseif($etape->termine)
                            <span class="badge bg-success ms-2">Terminé</span>
                        @endif
                    </button>
                </h2>
                <div id="collapse{{ $etape->id }}" class="accordion-collapse collapse {{ $etape->en_cours ? 'show' : '' }}" data-bs-parent="#ceremonyAccordion">
                    <div class="accordion-body accordion-body-content">
                        {!! nl2br($etape->description) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection