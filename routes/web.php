<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreOrController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\JeuxController;
use App\Http\Controllers\UrneController;
use App\Http\Controllers\PratiqueController;
use App\Http\Controllers\AdminController;


Route::get('/', fn() => view('landing'))->name('landing');


Route::get('/home', fn() => view('home'))->name('home');


Route::view('/notre-histoire', 'pages.histoire');
Route::view('/ceremonie-religieuse', 'pages.ceremonie');
Route::view('/mairie', 'pages.mairie');
Route::view('/menu', 'pages.menu');



//Route::view('/galerie', 'pages.galerie');
//Route::view('/livre-or', 'pages.livre-or');
//Route::view('/urne', 'pages.urne');


Route::get('/livre-or', [LivreOrController::class, 'index']);
Route::post('/livre-or', [LivreOrController::class, 'store']);

Route::get('/galerie', [GalerieController::class, 'index']);
Route::post('/galerie', [GalerieController::class, 'store']);


// Jeux
//Route::view('/jeux/qui-de-nous-2', 'jeux.qui2');
//Route::view('/jeux/chasse-photo', 'jeux.chasse-photo');
//Route::view('/jeux/autre-1', 'jeux.autre1');
//Route::view('/jeux/autre-2', 'jeux.autre2');
//Route::get('/jeux/chasse-photo', [JeuxController::class, 'chassePhoto']);
//Route::post('/jeux/chasse-photo/submit', [JeuxController::class, 'submitChassePhoto'])->name('jeux.chasse-photo.submit');
//Route::get('/jeux/qui-de-nous-2', [JeuxController::class, 'quiDeux']);
//Route::get('/jeux/chasse-photo', [JeuxController::class, 'chassePhoto']);
//Route::post('/jeux/chasse-photo/submit', [JeuxController::class, 'submitChassePhoto'])->name('jeux.chasse-photo.submit');
//Route::post('/jeux/qui-de-nous-2/submit', [JeuxController::class, 'submitQuiDeux'])->name('jeux.qui2.submit');
// Routes pour les jeux
Route::get('/jeux/qui-de-nous-2', [JeuxController::class, 'quiDeux'])->name('jeux.quiDeux');
Route::post('/jeux/qui-deux', [JeuxController::class, 'submitQuiDeux'])->name('jeux.submitQuiDeux');
Route::get('/jeux/resultats/{session}', [JeuxController::class, 'resultats'])->name('jeux.resultats');
Route::get('/jeux/chasse-photo', [JeuxController::class, 'chassePhoto'])->name('jeux.chassePhoto');
Route::post('/jeux/chasse-photo', [JeuxController::class, 'submitChassePhoto'])->name('jeux.submitChassePhoto');

// Routes pour l'administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des questions
    Route::get('/questions', [AdminController::class, 'questions'])->name('questions');
    Route::post('/questions', [AdminController::class, 'storeQuestion'])->name('storeQuestion');
    Route::put('/questions/{question}', [AdminController::class, 'updateQuestion'])->name('updateQuestion');
    Route::delete('/questions/{question}', [AdminController::class, 'deleteQuestion'])->name('deleteQuestion');
    
    // Gestion des sessions
    Route::get('/sessions', [AdminController::class, 'sessions'])->name('sessions');
    Route::post('/sessions', [AdminController::class, 'storeSession'])->name('storeSession');
    Route::put('/sessions/{session}', [AdminController::class, 'updateSession'])->name('updateSession');
    Route::post('/sessions/{session}/lancer', [AdminController::class, 'lancerSession'])->name('lancerSession');
    Route::post('/sessions/{session}/arreter', [AdminController::class, 'arreterSession'])->name('arreterSession');
    
    // Gestion de la chasse photo
    Route::get('/chasse-photos/{session}', [AdminController::class, 'chassePhotosSubmissions'])->name('chassePhotosSubmissions');
    Route::post('/chasse-photos/{chassePhoto}/validate', [AdminController::class, 'validateChassePhoto'])->name('validateChassePhoto');

    // Résultats
    Route::get('/resultats/{session}', [AdminController::class, 'resultats'])->name('resultats');
});

// Urne / paiements
Route::get('/urne', [UrneController::class, 'index']);
Route::post('/urne/payer', [UrneController::class, 'payer']);
Route::get('/urne/success', [UrneController::class, 'success']);
Route::get('/urne/cancel', [UrneController::class, 'cancel']);
Route::post('/webhook/stripe', [UrneController::class, 'stripeWebhook']);

Route::get('/details-pratiques', [PratiqueController::class, 'index'])->name('details.pratiques');