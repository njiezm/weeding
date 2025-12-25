<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeScan extends Model
{
    use HasFactory;

    /**
     * Indique à Laravel de ne pas gérer les colonnes created_at et updated_at.
     */
    public $timestamps = false;

    protected $fillable = [
        'qr_code_id',
        'ip_address',
        'user_agent',
        'location_data',
        'fingerprint_id',
        'screen_resolution',
        'precise_location',
        'location_permission_status',
        'scanned_at', // <-- AJOUTÉ
        'client_logs'
    ];

    protected $casts = [
        'location_data' => 'array',
        'precise_location' => 'array',
        'scanned_at' => 'datetime', // <-- LA LIGNE MAGIQUE
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}