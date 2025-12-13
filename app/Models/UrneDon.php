<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrneDon extends Model
{
    protected $fillable = [
        'participant_id',
        'montant',
        'message'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
