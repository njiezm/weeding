<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeCeremonie extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'icone',
        'ordre',
        'en_cours',
        'termine'
    ];
}