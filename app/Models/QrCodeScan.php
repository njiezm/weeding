<?php
// app/Models/QrCodeScan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code_id',
        'ip_address',
        'user_agent',
        'location_data', // Localisation par IP
        'fingerprint_id', // NOUVEAU
        'screen_resolution', // NOUVEAU
        'precise_location', // NOUVEAU
        'location_permission_status', // NOUVEAU
    ];

    protected $casts = [
        'location_data' => 'array',
        'precise_location' => 'array',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}