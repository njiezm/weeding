<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreOrController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\JeuxController;
use App\Http\Controllers\UrneController;
use App\Http\Controllers\PratiqueController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QrCodeController;


Route::get('/', fn() => view('landing'))->name('landing');

// routes/web.php

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
// Routes pour les nouveaux jeux
Route::get('/jeux/mots-croises', [JeuxController::class, 'motsCroises'])->name('jeux.motsCroises');
Route::post('/jeux/mots-croises', [JeuxController::class, 'submitMotsCroises'])->name('jeux.submitMotsCroises');
Route::get('/jeux/resultats-mots-croises', [JeuxController::class, 'resultatsMotsCroises'])->name('jeux.resultatsMotsCroises');
Route::get('/jeux/memory', [JeuxController::class, 'memory'])->name('jeux.memory');
Route::post('/jeux/memory', [JeuxController::class, 'submitMemory'])->name('jeux.submitMemory');
Route::get('/jeux/resultats-memory', [JeuxController::class, 'resultatsMemory'])->name('jeux.resultatsMemory');


// Routes pour l'administration
Route::prefix('admin190964')->name('admin.')->group(function () {
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

    // Gestion des étapes de la cérémonie
    Route::get('/etapes-ceremonie', [AdminController::class, 'etapesCeremonie'])->name('etapesCeremonie');
    Route::post('/etapes-ceremonie', [AdminController::class, 'storeEtapeCeremonie'])->name('storeEtapeCeremonie');
    Route::put('/etapes-ceremonie/{etape}', [AdminController::class, 'updateEtapeCeremonie'])->name('updateEtapeCeremonie');
    Route::delete('/etapes-ceremonie/{etape}', [AdminController::class, 'deleteEtapeCeremonie'])->name('deleteEtapeCeremonie');
    Route::post('/etapes-ceremonie/{etape}/en-cours', [AdminController::class, 'marquerEnCours'])->name('marquerEnCours');
    Route::post('/etapes-ceremonie/{etape}/terminer', [AdminController::class, 'marquerTermine'])->name('marquerTermine');
    Route::post('/etapes-ceremonie/{etape}/non-terminer', [AdminController::class, 'marquerNonTermine'])->name('marquerNonTermine');


    //
    // Routes pour les mots croisés
    Route::get('/mots-croises', [AdminController::class, 'motsCroises'])->name('motsCroises');
    Route::post('/mots-croises', [AdminController::class, 'storeMotsCroises'])->name('storeMotsCroises');
    Route::get('/mots-croises/{motsCroises}/edit', [AdminController::class, 'editMotsCroises'])->name('editMotsCroises');
    Route::put('/mots-croises/{motsCroises}', [AdminController::class, 'updateMotsCroises'])->name('updateMotsCroises');
    Route::post('/mots-croises/{motsCroises}/mots', [AdminController::class, 'storeMot'])->name('storeMot');
    Route::put('/mots/{mot}', [AdminController::class, 'updateMot'])->name('updateMot');
    Route::delete('/mots/{mot}', [AdminController::class, 'deleteMot'])->name('deleteMot');
    
    // Routes pour les cartes memory
    Route::get('/memory-cards', [AdminController::class, 'memoryCards'])->name('memoryCards');
    Route::post('/memory-cards', [AdminController::class, 'storeMemoryCard'])->name('storeMemoryCard');
    Route::put('/memory-cards/{card}', [AdminController::class, 'updateMemoryCard'])->name('updateMemoryCard');
    Route::delete('/memory-cards/{card}', [AdminController::class, 'deleteMemoryCard'])->name('deleteMemoryCard');
    
    // Routes pour les jeux
    Route::get('/mots-croises', [AdminController::class, 'motsCroises'])->name('motsCroises');
    Route::post('/mots-croises', [AdminController::class, 'storeMotsCroises'])->name('storeMotsCroises');
    Route::get('/mots-croises/{motsCroises}/edit', [AdminController::class, 'editMotsCroises'])->name('editMotsCroises');
    Route::put('/mots-croises/{motsCroises}', [AdminController::class, 'updateMotsCroises'])->name('updateMotsCroises');
    Route::post('/mots-croises/{motsCroises}/mots', [AdminController::class, 'storeMot'])->name('storeMot');
    Route::put('/mots/{mot}', [AdminController::class, 'updateMot'])->name('updateMot');
    Route::delete('/mots/{mot}', [AdminController::class, 'deleteMot'])->name('deleteMot');
    
    // Routes pour les cartes memory
    Route::get('/memory-cards', [AdminController::class, 'memoryCards'])->name('memoryCards');
    Route::post('/memory-cards', [AdminController::class, 'storeMemoryCard'])->name('storeMemoryCard');
    Route::put('/memory-cards/{card}', [AdminController::class, 'updateMemoryCard'])->name('updateMemoryCard');
    Route::delete('/memory-cards/{card}', [AdminController::class, 'deleteMemoryCard'])->name('deleteMemoryCard');

    // Résultats
    Route::get('/resultats/{session}', [AdminController::class, 'resultats'])->name('resultats');

    // Gestion des QR Codes
    // Gestion des QR Codes
Route::get('/qrcodes', [QrCodeController::class, 'index'])->name('qrcodes.index');
Route::post('/qrcodes', [QrCodeController::class, 'store'])->name('qrcodes.store');
Route::get('/qrcodes/{qrCode}/stats', [QrCodeController::class, 'stats'])->name('qrcodes.stats');
Route::get('/qrcodes/{qrCode}/download', [QrCodeController::class, 'download'])->name('qrcodes.download');
Route::get('/qrcodes/{scan}/logs', [QrCodeController::class, 'downloadLogs'])->name('qrcodes.downloadLogs');
    
});

// Route PUBLIQUE pour le suivi des scans (affiche une page)
Route::get('/qr/track/{uuid}', [QrCodeController::class, 'track'])->name('qr.track');

// Route PUBLIQUE pour recevoir les données AJAX du scan
Route::post('/qr/scan/store', [QrCodeController::class, 'storeScan'])->name('qr.scan.store');

// Urne / paiements
Route::get('/urne', [UrneController::class, 'index']);
Route::post('/urne/payer', [UrneController::class, 'payer']);
Route::get('/urne/success', [UrneController::class, 'success']);
Route::get('/urne/cancel', [UrneController::class, 'cancel']);
Route::post('/webhook/stripe', [UrneController::class, 'stripeWebhook']);

Route::get('/details-pratiques', [PratiqueController::class, 'index'])->name('details.pratiques');






