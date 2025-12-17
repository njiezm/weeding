<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'equipe'
    ];

    public function reponses()
    {
        return $this->hasMany(ReponseQuiDeux::class);
    }
}