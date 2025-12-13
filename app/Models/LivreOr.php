<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivreOr extends Model
{
    protected $fillable = [
        'participant_id',
        'message'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
