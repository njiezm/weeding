<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotCroise extends Model
{
    protected $table = 'mots';
    
    protected $fillable = [
        'mots_croise_id',  // Utilisez le nom correct de la colonne
        'mot',
        'definition',
        'position_x',
        'position_y',
        'direction'
    ];

    public function motsCroise()
    {
        return $this->belongsTo(MotsCroises::class, 'mots_croise_id');  // Spécifiez explicitement la clé étrangère
    }
}

