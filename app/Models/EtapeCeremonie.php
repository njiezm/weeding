<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeCeremonie extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'icone', 'ordre', 'en_cours', 'termine'
    ];

    // Relation avec les lectures (une étape peut avoir plusieurs lectures)
    public function lectures()
    {
        return $this->hasMany(Lecture::class)->orderBy('ordre');
    }

    // Relation avec les chants
    public function chants()
    {
        return $this->hasMany(Chant::class)->orderBy('ordre');
    }

    // Relation avec les prières
    public function prieres()
    {
        return $this->hasMany(Priere::class)->orderBy('ordre');
    }
}