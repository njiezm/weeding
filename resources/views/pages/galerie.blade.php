@extends('layout')

@section('content')

<h2 class="gallery-heading text-center">
    📸 Galerie Photo Participative
</h2>

@if(session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

<div class="upload-card">
    <h4 class="text-center mb-4 fw-bold" style="color:var(--vert-sapin);">
        Partagez vos moments instantanément !
    </h4>
    
    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3 g-3">
            <div class="col-md-6">
                <input
                    type="text"
                    name="prenom"
                    class="form-control form-control-lg"
                    placeholder="Votre prénom"
                    required>
            </div>
            <div class="col-md-6">
                <input
                    type="text"
                    name="nom"
                    class="form-control form-control-lg"
                    placeholder="Votre nom"
                    required>
            </div>
        </div>

        <div class="mb-4">
            <label for="photo-upload" class="form-label fw-bold text-muted">Sélectionner un fichier image :</label>
            <input
                type="file"
                name="photo"
                id="photo-upload"
                class="form-control"
                accept="image/*"
                required>
        </div>

        <button class="btn btn-upload-photo w-100">
            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Envoyer la photo maintenant
        </button>
    </form>
</div>

<h3 class="fw-bold mb-4" style="color:var(--vert-sapin);">
    <i class="fa-solid fa-camera me-2 text-dore-accent"></i> Les clichés de nos invités
</h3>

<div class="row g-4">
@foreach($photos as $photo)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card photo-item-card h-100">
            <img
                src="{{ asset('storage/' . $photo->path) }}"
                class="card-img-top"
                alt="photo mariage">

            <div class="card-body p-2 text-center">
                <small class="text-muted photo-meta">
                    Par {{ $photo->participant->prenom }}
                </small>
            </div>
        </div>
    </div>
@endforeach
</div>

@if(count($photos) == 0)
<div class="alert alert-info text-center mt-5">
    Aucune photo n'a encore été partagée. Soyez le premier !
</div>
@endif

@endsection