<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'participant_id',
        'path',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
