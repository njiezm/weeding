<!-- resources/views/qrcode/track.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirection en cours...</title>
    <style>
        body { font-family: sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { text-align: center; }
        .spinner { border: 4px solid rgba(0, 0, 0, 0.1); width: 36px; height: 36px; border-radius: 50%; border-left-color: #09f; animation: spin 1s linear infinite; margin: 0 auto 10px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <p>Redirection vers votre destination...</p>
    </div>

    <script>
        window.qrCodeData = @json($data);
        window.csrfToken = '{{ csrf_token() }}';
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            
            // === COLLECTEUR DE LOGS ===
            let allLogs = [];
            function logAndSave(level, message, data = null) {
                const timestamp = new Date().toISOString();
                const logEntry = `[${timestamp}] [${level}] ${message} ${data ? JSON.stringify(data) : ''}`;
                allLogs.push(logEntry);
                
                if (level === 'error') {
                    console.error(message, data);
                } else {
                    console.log(message, data);
                }
            }
            // ==========================

            (async () => {
                const data = { ...window.qrCodeData };
                const destinationUrl = data.destination_url;

                logAndSave('INFO', 'DÉBUT DU PROCESSUS DE SCAN');
                logAndSave('INFO', 'Données initiales reçues de Laravel', data);

                // 1. CRÉATION DE L'IDENTIFIANT
                const userAgent = navigator.userAgent;
                const screenResolution = `${screen.width}x${screen.height}`;
                data.screen_resolution = screenResolution;
                
                try {
                    data.fingerprint_id = btoa(userAgent + '|' + screenResolution);
                    logAndSave('SUCCESS', 'Fingerprint ID généré', { fingerprint_id: data.fingerprint_id });
                } catch (e) {
                    logAndSave('ERROR', 'ERREUR lors de la génération du fingerprint', { error: e.message });
                    data.fingerprint_id = 'fallback_' + Date.now();
                }
                
                // 2. GÉOLOCALISATION (AVEC TIMEOUT)
                if ("geolocation" in navigator) {
                    logAndSave('INFO', 'Demande de géolocalisation en cours...');
                    const geoOptions = { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 };

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            data.precise_location = { lat: position.coords.latitude, lon: position.coords.longitude, accuracy: position.coords.accuracy };
                            data.location_permission_status = 'granted';
                            logAndSave('SUCCESS', 'Géolocalisation accordée', data.precise_location);
                            sendDataAndRedirect();
                        },
                        (error) => {
                            logAndSave('ERROR', 'ERREUR de géolocalisation', { code: error.code, message: error.message });
                            if (error.code === error.TIMEOUT) {
                                logAndSave('WARNING', 'La demande de géolocalisation a expiré (probablement bloquée par le navigateur).');
                            }
                            data.location_permission_status = 'denied';
                            sendDataAndRedirect();
                        },
                        geoOptions
                    );
                } else {
                    logAndSave('WARNING', 'Géolocalisation non disponible sur cet appareil.');
                    data.location_permission_status = 'unavailable';
                    sendDataAndRedirect();
                }

                function sendDataAndRedirect() {
                    // On ajoute tous les logs collectés à l'objet qui sera envoyé
                    data.client_logs = allLogs.join('\n');

                    logAndSave('INFO', 'Préparation de l\'envoi des données. Objet final (logs non inclus).');
                    
                    fetch('/qr/scan/store', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                           return response.text().then(text => { throw new Error(text) });
                        }
                        return response.json();
                    })
                    .then(result => {
                        logAndSave('SUCCESS', 'Réponse JSON du serveur', result);
                    })
                    .catch(error => {
                        logAndSave('ERROR', 'ERREUR pendant la requête fetch', { message: error.message });
                    })
                    .finally(() => {
                        logAndSave('INFO', `Redirection vers : ${destinationUrl}`);
                        logAndSave('INFO', 'FIN DU PROCESSUS DE SCAN');
                        window.location.href = destinationUrl;
                    });
                }

            })();
        });
    </script>
</body>
</html>