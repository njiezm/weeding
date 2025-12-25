<?php
namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrCodeScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Pour le debug
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

class QrCodeController extends Controller
{
    // Page d'administration pour lister et créer des QR codes
    public function index()
    {
        $qrCodes = QrCode::orderBy('source')->orderBy('name')->get();
        return view('admin.qrcodes.index', compact('qrCodes'));
    }

    // Enregistrer un nouveau QR code
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|in:tableau,whatsapp,entree,eglise,autre',
            'destination_url' => 'required|url',
        ]);

        QrCode::create($request->all());

        return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code créé avec succès.');
    }

    // Page pour voir les statistiques d'un QR code (MISE À JOUR)
    public function stats(QrCode $qrCode)
    {
        $scans = $qrCode->scans()->latest()->paginate(50);
        return view('admin.qrcodes.stats', compact('qrCode', 'scans'));
    }

    // La route de suivi qui affiche une page de chargement (MISE À JOUR)
    public function track($uuid)
    {
        $qrCode = QrCode::where('uuid', $uuid)->where('is_active', true)->firstOrFail();
        
        // On passe les données de base à la vue pour que le JS les récupère
        $data = [
            'uuid' => $qrCode->uuid,
            'destination_url' => $qrCode->destination_url,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'location_data' => $this->getLocationData(request()->ip()),
        ];

        return view('qrcode.track', compact('data'));
    }

    // NOUVELLE route pour recevoir les données AJAX du JS
    public function storeScan(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|string|exists:qr_codes,uuid',
            'fingerprint_id' => 'nullable|string',
            'screen_resolution' => 'nullable|string',
            'precise_location' => 'nullable|array',
            'location_permission_status' => 'nullable|string|in:granted,denied,prompt,unavailable',
        ]);

        $qrCode = QrCode::where('uuid', $validated['uuid'])->firstOrFail();

        QrCodeScan::create([
            'qr_code_id' => $qrCode->id,
            'ip_address' => $request->input('ip_address'),
            'user_agent' => $request->input('user_agent'),
            'location_data' => $request->input('location_data'),
            'fingerprint_id' => $validated['fingerprint_id'],
            'screen_resolution' => $validated['screen_resolution'],
            'precise_location' => $validated['precise_location'],
            'location_permission_status' => $validated['location_permission_status'],
        ]);

        return response()->json(['status' => 'success']);
    }

    // Fonction pour obtenir des données de localisation (inchangée)
    private function getLocationData($ip)
    {
        if ($ip === '127.0.0.1') {
            return ['ip' => $ip, 'status' => 'local'];
        }
        
        $data = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,query");
        return json_decode($data, true);
    }
}