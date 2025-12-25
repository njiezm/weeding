@extends('layout')

@section('content')

<h2 class="guestbook-heading text-center">
    Livre d’or Digital 🖊️
</h2>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="signature-card">
            
            <p class="instruction-text text-center">
                Laissez-nous vos vœux de bonheur, vos conseils de mariage, ou un joli souvenir !
            </p>

            @if(session('success'))
            <div class="alert alert-success text-center mb-4">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST">
                @csrf

                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <input
                            type="text"
                            name="prenom"
                            class="form-control"
                            placeholder="Votre prénom"
                            required>
                    </div>
                    <div class="col-md-6">
                        <input
                            type="text"
                            name="nom"
                            class="form-control"
                            placeholder="Votre nom"
                            required>
                    </div>
                </div>

                <textarea
                    name="message"
                    class="form-control mb-4"
                    rows="5"
                    placeholder="« Chers Gilles et Maëva, nous vous souhaitons tout le bonheur du monde... »"
                    required></textarea>

                <button class="btn btn-signature w-100">
                    <i class="fa-solid fa-pen-fancy me-2"></i> Signer le livre d’or
                </button>
            </form>
        </div>
        
        <h3 style="color:#e8e8e8; /*var(--vert-sapin);*/" class="fw-bold mb-4 text-center" style="color:var(--vert-sapin); font-family:var(--font-pro);">
            <i class="fa-solid fa-comments me-2 text-dore-accent"></i> Messages et Vœux
        </h3>

        @foreach($messages as $msg)
        <div class="message-card">
            <p class="message-content">
                "{{ $msg->message }}"
            </p>
            
            <hr class="my-2">
            
            <div class="d-flex justify-content-between align-items-center">
                <span class="message-author">
                    <i class="fa-solid fa-user-pen me-1"></i> {{ $msg->participant->prenom }} {{ $msg->participant->nom }}
                </span>
                <small class="message-date">
                    Posté le {{ $msg->created_at->format('d/m/Y') }}
                </small>
            </div>
        </div>
        @endforeach

        @if(count($messages) == 0)
        <div class="alert alert-info text-center mt-5">
            Soyez le premier à laisser un message aux mariés !
        </div>
        @endif

    </div>
</div>

@endsection