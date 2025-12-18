<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotsCroises extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'taille',
        'actif'
    ];

    public function mots()
    {
        return $this->hasMany(MotCroise::class, 'mots_croise_id');  // Spécifiez explicitement la clé étrangère
    }
}