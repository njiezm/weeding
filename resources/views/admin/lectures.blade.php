@extends('layout')
@section('content')
<!-- ... (en-tête similaire à votre vue étapes) -->

<!-- Formulaire d'ajout -->
<div class="card">
    <div class="card-header">
        <h5>Ajouter une lecture</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.storeLecture') }}" method="POST">
            @csrf
            <!-- Champs pour titre, référence, contenu (textarea), auteur, ordre -->
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</div>

<!-- Tableau des lectures -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Liste des lectures</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Titre</th>
                    <th>Référence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lectures as $lecture)
                <tr>
                    <td>{{ $lecture->ordre }}</td>
                    <td>{{ $lecture->titre }}</td>
                    <td>{{ $lecture->reference }}</td>
                    <td>
                        <!-- Boutons Modifier/Supprimer -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modals pour l'édition (similaire à votre vue étapes) -->
@endsection