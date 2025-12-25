<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrCodeScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        'source' => 'required|string|max:255',  // Remplacer la validation par une simple chaîne
        'destination_url' => 'required|url',
    ]);

    QrCode::create($request->all());

    return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code créé avec succès.');
}

    // Page pour voir les statistiques d'un QR code
    public function stats(QrCode $qrCode)
    {
         $scans = $qrCode->scans()->orderBy('scanned_at', 'desc')->paginate(50);
        return view('admin.qrcodes.stats', compact('qrCode', 'scans'));
    }

    // La route de suivi qui affiche une page de chargement
    public function track($uuid)
    {
        $qrCode = QrCode::where('uuid', $uuid)->where('is_active', true)->firstOrFail();
        
        $data = [
            'uuid' => $qrCode->uuid,
            'destination_url' => $qrCode->destination_url,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'location_data' => $this->getLocationData(request()->ip()),
        ];

        return view('qrcode.track', compact('data'));
    }

    // Route pour recevoir les données AJAX du JS
    public function storeScan(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|string|exists:qr_codes,uuid',
            'fingerprint_id' => 'nullable|string',
            'screen_resolution' => 'nullable|string',
            'precise_location' => 'nullable|array',
            'location_permission_status' => 'nullable|string|in:granted,denied,prompt,unavailable',
            'client_logs' => 'nullable|string',
        ]);

        $qrCode = QrCode::where('uuid', $validated['uuid'])->firstOrFail();

        // Écriture du fichier de logs
        if (!empty($validated['client_logs'])) {
            $logDirectory = 'logs/qr_scans';
            $filename = 'scan_log_' . $validated['uuid'] . '_' . now()->format('Y-m-d_H-i-s-u') . '.txt';
            Storage::disk('local')->makeDirectory($logDirectory);
            Storage::disk('local')->put($logDirectory . '/' . $filename, $validated['client_logs']);
        }

        QrCodeScan::create([
            'qr_code_id' => $qrCode->id,
            'ip_address' => $request->input('ip_address'),
            'user_agent' => $request->input('user_agent'),
            'location_data' => $request->input('location_data'),
            'fingerprint_id' => $validated['fingerprint_id'] ?? null,
            'screen_resolution' => $validated['screen_resolution'] ?? null,
            'precise_location' => $validated['precise_location'] ?? null,
            'location_permission_status' => $validated['location_permission_status'] ?? null,
            'scanned_at' => now(), // <-- On ajoute la date et heure actuelles
        ]);
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Récupère les données de localisation basées sur l'IP via une API externe.
     *
     * @param string $ip
     * @return array|null
     */
    private function getLocationData($ip)
    {
        if ($ip === '127.0.0.1') {
            return ['ip' => $ip, 'status' => 'local'];
        }
        
        $data = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,query");
        return json_decode($data, true);
    }

    public function downloadLogs(QrCodeScan $scan)
{
    if (!$scan->client_logs) {
        abort(404, 'Logs non trouvés pour ce scan.');
    }

    $filename = 'logs_scan_' . $scan->qrCode->uuid . '_' . $scan->scanned_at->format('Y-m-d_H-i-s') . '.txt';
    
    return response($scan->client_logs)
        ->header('Content-Type', 'text/plain')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}

/**
 * Télécharge un QR code personnalisé avec le logo
 *
 * @param QrCode $qrCode
 * @return \Illuminate\Http\Response
 */
public function download(QrCode $qrCode)
{
    try {
        $filename = 'qrcode_' . str_replace(' ', '_', $qrCode->name) . '.svg';

        // Génération du QR code en SVG avec logo
        $qrCodeSvg = QrCodeGenerator::format('svg')
            ->size(500)
            ->errorCorrection('H')
            ->color(0, 100, 0)
            ->merge(public_path('images/logo-metg.png'), 0.2, true)
            ->generate(route('qr.track', $qrCode->uuid));

        return response($qrCodeSvg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    } catch (\Exception $e) {
        Log::error('Erreur lors de la génération du QR code : ' . $e->getMessage());
        return redirect()->back()->with('error', 'Impossible de générer le QR code.');
    }
}




}