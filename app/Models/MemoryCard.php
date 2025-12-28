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

    // Dans app/Models/MemoryCard.php

/**
 * Obtenir l'URL complète de l'image.
 */
public function getImageUrlAttribute()
{
    // asset() génère la bonne URL pour un fichier dans le dossier public
    return asset($this->image_path);
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