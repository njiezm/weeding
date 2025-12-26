@extends('layout')

@section('content')
<style>
    .camera-container {
        position: relative;
        display: none;
        margin-bottom: 15px;
    }
    
    .camera-container.active {
        display: block;
    }
    
    #video {
        width: 100%;
        max-height: 300px;
        border-radius: 8px;
        background-color: #000;
    }
    
    .camera-controls {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }
    
    .camera-btn {
        padding: 8px 15px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }
    
    .capture-btn {
        background-color: var(--vert-sapin);
        color: white;
    }
    
    .cancel-btn {
        background-color: #6c757d;
        color: white;
    }
    
    .captured-photo {
        display: none;
        width: 100%;
        max-height: 300px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .captured-photo.active {
        display: block;
    }
    
    .upload-options {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .upload-option {
        flex: 1;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .upload-option.active {
        border-color: var(--vert-sapin);
        background-color: rgba(0, 128, 0, 0.1);
    }
    
    .photo-preview {
        display: none;
        width: 100%;
        max-height: 300px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .photo-preview.active {
        display: block;
    }
    
    .debug-info {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 15px;
        font-family: monospace;
        font-size: 12px;
        color: #6c757d;
    }
</style>

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
    
    <form method="POST" enctype="multipart/form-data" id="photo-form">
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

        <div class="upload-options mb-3">
            <div class="upload-option active" id="file-option">
                <i class="fa-solid fa-image me-2"></i> Choisir depuis la galerie
            </div>
            <div class="upload-option" id="camera-option">
                <i class="fa-solid fa-camera me-2"></i> Prendre une photo
            </div>
        </div>

        <div class="mb-4" id="file-upload-container">
            <label for="photo-upload" class="form-label fw-bold text-muted">Sélectionner un fichier image :</label>
            <input
                type="file"
                name="photo"
                id="photo-upload"
                class="form-control"
                accept="image/*"
                required>
        </div>
        
        <div class="camera-container" id="camera-container">
            <video id="video" autoplay></video>
            <div class="camera-controls">
                <button type="button" class="camera-btn capture-btn" id="capture-btn">
                    <i class="fa-solid fa-camera me-2"></i> Capturer
                </button>
                <button type="button" class="camera-btn cancel-btn" id="cancel-camera-btn">
                    <i class="fa-solid fa-times me-2"></i> Annuler
                </button>
            </div>
        </div>
        
        <canvas id="canvas" style="display:none;"></canvas>
        <img id="captured-photo" class="captured-photo" alt="Photo capturée">
        <img id="photo-preview" class="photo-preview" alt="Aperçu de la photo">
        
        <input type="hidden" name="photo_data" id="photo-data">
        
        <button class="btn btn-upload-photo w-100" id="submit-btn">
            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Envoyer la photo maintenant
        </button>
    </form>
</div>

<h3 style="color:#e8e8e8; /*var(--vert-sapin);*/" class="fw-bold mb-4" style="color:var(--vert-sapin);">
    <i class="fa-solid fa-camera me-2 text-dore-accent"></i> Les clichés de nos invités
</h3>

<!-- Information de débogage -->
<div class="debug-info">
    <strong>Informations de débogage (à supprimer en production) :</strong><br>
    APP_URL: {{ config('app.url') }}<br>
    Lien symbolique public/storage: @if(file_exists(public_path('storage'))) Existe @else N'existe pas @endif<br>
    Permissions du dossier storage/app/public: {{ substr(sprintf('%o', fileperms(storage_path('app/public'))), -4) }}
</div>

<div class="row g-4">
@foreach($photos as $photo)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card photo-item-card h-100">
            <!-- URL générée pour le débogage -->
            @php
                $imageUrl = Storage::url($photo->path);
                $fullPath = storage_path('app/public/' . $photo->path);
                $fileExists = file_exists($fullPath);
            @endphp
            
            <!-- Afficher l'image avec une URL absolue -->
            <img
                src="{{ url($imageUrl) }}"
                class="card-img-top"
                alt="photo mariage"
                onerror="this.src='https://via.placeholder.com/300x300.png?text=Photo+non+disponible'">

            <div class="card-body p-2 text-center">
                <small class="text-muted photo-meta">
                    Par {{ $photo->participant->prenom }}
                </small>
                <!-- Informations de débogage pour cette image -->
                <div class="debug-info mt-2">
                    URL: {{ $imageUrl }}<br>
                    Chemin complet: {{ $fullPath }}<br>
                    Fichier existe: @if($fileExists) Oui @else Non @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>

@if(count($photos) == 0)
<div style="color:#e8e8e8; /*var(--vert-sapin);*/" class="alert alert-info text-center mt-5">
    Aucune photo n'a encore été partagée. Soyez le premier !
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileOption = document.getElementById('file-option');
    const cameraOption = document.getElementById('camera-option');
    const fileUploadContainer = document.getElementById('file-upload-container');
    const cameraContainer = document.getElementById('camera-container');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capture-btn');
    const cancelCameraBtn = document.getElementById('cancel-camera-btn');
    const capturedPhoto = document.getElementById('captured-photo');
    const photoData = document.getElementById('photo-data');
    const photoUpload = document.getElementById('photo-upload');
    const photoPreview = document.getElementById('photo-preview');
    const photoForm = document.getElementById('photo-form');
    const submitBtn = document.getElementById('submit-btn');
    
    let stream = null;
    
    // Gestion du changement entre l'option fichier et caméra
    fileOption.addEventListener('click', function() {
        fileOption.classList.add('active');
        cameraOption.classList.remove('active');
        fileUploadContainer.style.display = 'block';
        cameraContainer.classList.remove('active');
        capturedPhoto.classList.remove('active');
        photoPreview.classList.remove('active');
        stopCamera();
        photoUpload.required = true;
        photoData.value = '';
    });
    
    cameraOption.addEventListener('click', function() {
        cameraOption.classList.add('active');
        fileOption.classList.remove('active');
        fileUploadContainer.style.display = 'none';
        cameraContainer.classList.add('active');
        photoUpload.required = false;
        startCamera();
    });
    
    // Démarrer la caméra
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                } 
            });
            video.srcObject = stream;
        } catch (err) {
            console.error("Erreur lors de l'accès à la caméra: ", err);
            alert("Impossible d'accéder à la caméra. Veuillez vérifier les permissions de votre navigateur.");
            fileOption.click(); // Retourner à l'option fichier
        }
    }
    
    // Arrêter la caméra
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }
    
    // Capturer la photo
    captureBtn.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        
        canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            capturedPhoto.src = url;
            capturedPhoto.classList.add('active');
            cameraContainer.classList.remove('active');
            
            // Convertir en base64 pour l'envoi
            const reader = new FileReader();
            reader.onloadend = function() {
                photoData.value = reader.result;
            }
            reader.readAsDataURL(blob);
            
            stopCamera();
        }, 'image/jpeg', 0.95);
    });
    
    // Annuler la prise de photo
    cancelCameraBtn.addEventListener('click', function() {
        stopCamera();
        fileOption.click();
    });
    
    // Aperçu de l'image sélectionnée
    photoUpload.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.classList.add('active');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Gestion de la soumission du formulaire
    photoForm.addEventListener('submit', function(e) {
        if (photoData.value) {
            // Si une photo a été prise avec la caméra, créer un fichier à partir des données base64
            e.preventDefault();
            
            fetch(photoData.value)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], "camera_photo.jpg", { type: "image/jpeg" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoUpload.files = dataTransfer.files;
                    
                    // Soumettre le formulaire
                    photoForm.submit();
                });
        }
    });
});
</script>

@endsection