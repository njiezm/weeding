<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemoryCard extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'image_path',
        'pair_id',
        'actif'
    ];

    /**
     * Obtenir l'URL complète de l'image.
     */
    public function getImageUrlAttribute()
    {
        return ($this->image_path);
    }

    /**
     * Obtenir la paire de cette carte.
     */
    public function getPair()
    {
        return MemoryCard::where('pair_id', $this->pair_id)
            ->where('id', '!=', $this->id)
            ->first();
    }
}