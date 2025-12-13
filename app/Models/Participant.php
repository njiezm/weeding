<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'nom',
        'prenom'
    ];

    public function livreOrs()
    {
        return $this->hasMany(LivreOr::class);
    }
}
