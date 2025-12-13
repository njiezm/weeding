<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreOrController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\JeuxController;
use App\Http\Controllers\UrneController;
use App\Http\Controllers\PratiqueController;

Route::get('/', fn() => view('landing'))->name('landing');


Route::get('/home', fn() => view('home'))->name('home');


Route::view('/notre-histoire', 'pages.histoire');
Route::view('/ceremonie-religieuse', 'pages.ceremonie');
Route::view('/mairie', 'pages.mairie');
Route::view('/menu', 'pages.menu');


//Route::view('/jeux/qui-de-nous-2', 'jeux.qui2');
//Route::view('/jeux/chasse-photo', 'jeux.chasse-photo');
Route::view('/jeux/autre-1', 'jeux.autre1');
Route::view('/jeux/autre-2', 'jeux.autre2');
Route::get('/jeux/chasse-photo', [JeuxController::class, 'chassePhoto']);
Route::post('/jeux/chasse-photo/submit', [JeuxController::class, 'submitChassePhoto'])->name('jeux.chasse-photo.submit');



//Route::view('/galerie', 'pages.galerie');
//Route::view('/livre-or', 'pages.livre-or');
//Route::view('/urne', 'pages.urne');


Route::get('/livre-or', [LivreOrController::class, 'index']);
Route::post('/livre-or', [LivreOrController::class, 'store']);

Route::get('/galerie', [GalerieController::class, 'index']);
Route::post('/galerie', [GalerieController::class, 'store']);


// Jeux
Route::get('/jeux/qui-de-nous-2', [JeuxController::class, 'quiDeux']);
Route::get('/jeux/chasse-photo', [JeuxController::class, 'chassePhoto']);
//Route::post('/jeux/chasse-photo/submit', [JeuxController::class, 'submitChassePhoto'])->name('jeux.chasse-photo.submit');
Route::post('/jeux/qui-de-nous-2/submit', [JeuxController::class, 'submitQuiDeux'])->name('jeux.qui2.submit');

// Urne / paiements
Route::get('/urne', [UrneController::class, 'index']);
Route::post('/urne/payer', [UrneController::class, 'payer']);
Route::get('/urne/success', [UrneController::class, 'success']);
Route::get('/urne/cancel', [UrneController::class, 'cancel']);
Route::post('/webhook/stripe', [UrneController::class, 'stripeWebhook']);

Route::get('/details-pratiques', [PratiqueController::class, 'index'])->name('details.pratiques');