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
    // Si le chemin commence par 'public/', le remplacer par 'storage/'
    if (strpos($this->image_path, 'public/') === 0) {
        return asset(str_replace('public/', 'storage/', $this->image_path));
    }
    
    // Sinon, essayer avec Storage::url()
    try {
        return Storage::url($this->image_path);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner le chemin direct
        return asset($this->image_path);
    }
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