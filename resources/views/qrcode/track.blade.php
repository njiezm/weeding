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

    <!-- On inclut FingerprintJS depuis un CDN -->
    <script src="https://fpjscdn.net/v3"></script>
    
    <!-- On passe les données de Laravel à JavaScript -->
    <script>
        window.qrCodeData = @json($data);
        window.csrfToken = '{{ csrf_token() }}';
    </script>

    <!-- Notre script de collecte -->
    <script>
        (async () => {
            const data = { ...window.qrCodeData };
            const destinationUrl = data.destination_url;

            // 1. Fingerprinting
            try {
                const fp = await FingerprintJS.load();
                const result = await fp.get();
                data.fingerprint_id = result.visitorId;
            } catch (e) {
                console.error("FingerprintJS error:", e);
                data.fingerprint_id = 'error';
            }

            // 2. Résolution d'écran
            data.screen_resolution = `${screen.width}x${screen.height}`;

            // 3. Géolocalisation précise
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        data.precise_location = {
                            lat: position.coords.latitude,
                            lon: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        };
                        data.location_permission_status = 'granted';
                        sendDataAndRedirect();
                    },
                    (error) => {
                        console.error("Geolocation error:", error);
                        data.location_permission_status = 'denied';
                        sendDataAndRedirect();
                    }
                );
            } else {
                data.location_permission_status = 'unavailable';
                sendDataAndRedirect();
            }

            function sendDataAndRedirect() {
                fetch('/qr/scan/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    console.log('Scan data sent:', result);
                })
                .catch(error => {
                    console.error('Error sending scan data:', error);
                })
                .finally(() => {
                    // Redirection finale dans tous les cas
                    window.location.href = destinationUrl;
                });
            }

        })();
    </script>
</body>
</html>