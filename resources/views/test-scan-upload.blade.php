<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Upload Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .test-section {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #2196F3;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        button:hover {
            background: #45a049;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .success {
            background: #c8e6c9;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .error {
            background: #ffcdd2;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        pre {
            background: #263238;
            color: #aed581;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        #result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test de la route de scan</h1>
        
        <div class="info">
            <strong>Route testée :</strong> <code>{{ route('regidoc.courriers.scan') }}</code><br>
            <strong>Méthode :</strong> POST<br>
            <strong>Champ attendu :</strong> pdf (fichier PDF)
        </div>

        <div class="test-section">
            <h2>📤 Test 1 : Upload manuel d'un PDF</h2>
            <p>Sélectionnez un fichier PDF pour tester l'upload :</p>
            <input type="file" id="pdfFile" accept=".pdf">
            <button onclick="testUpload()">Tester l'upload</button>
        </div>

        <div class="test-section">
            <h2>🔗 Test 2 : Vérifier l'accessibilité de la route</h2>
            <button onclick="testRouteAccess()">Tester la route</button>
        </div>

        <div class="test-section">
            <h2>📁 Test 3 : Vérifier le dossier de destination</h2>
            <p>Dossier attendu : <code>storage/tmp_scanne/</code></p>
            <div class="info">
                <strong>Local :</strong> <code>storage/app/public/tmp_scanne/</code><br>
                <strong>Production :</strong> <code>public_html/storage/tmp_scanne/</code>
            </div>
        </div>

        <div id="result"></div>
    </div>

    <script>
        function showResult(type, message, details = null) {
            const resultDiv = document.getElementById('result');
            let html = `<div class="${type}">
                <strong>${type === 'success' ? '✅ Succès' : type === 'error' ? '❌ Erreur' : 'ℹ️ Info'} :</strong><br>
                ${message}
            </div>`;
            
            if (details) {
                html += `<pre>${JSON.stringify(details, null, 2)}</pre>`;
            }
            
            resultDiv.innerHTML = html;
        }

        async function testUpload() {
            const fileInput = document.getElementById('pdfFile');
            const file = fileInput.files[0];
            
            if (!file) {
                showResult('error', 'Veuillez sélectionner un fichier PDF');
                return;
            }

            if (file.type !== 'application/pdf') {
                showResult('error', 'Le fichier doit être un PDF');
                return;
            }

            console.log('📤 Début de l\'upload...');
            console.log('Fichier:', file.name, 'Taille:', file.size, 'bytes');

            const formData = new FormData();
            formData.append('pdf', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            try {
                showResult('info', 'Upload en cours...');
                
                const response = await fetch('{{ route("regidoc.courriers.scan") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin' // IMPORTANT : Envoie les cookies de session
                });

                console.log('📥 Réponse reçue');
                console.log('Status:', response.status);
                console.log('Status Text:', response.statusText);
                console.log('Headers:', [...response.headers.entries()]);

                const contentType = response.headers.get('content-type');
                console.log('Content-Type:', contentType);

                let data;
                const text = await response.text();
                console.log('Réponse brute (200 premiers chars):', text.substring(0, 200));

                try {
                    data = JSON.parse(text);
                    console.log('JSON parsé:', data);
                } catch (e) {
                    console.error('Erreur parsing JSON:', e);
                    showResult('error', 'Le serveur a retourné une réponse non-JSON', {
                        status: response.status,
                        contentType: contentType,
                        responsePreview: text.substring(0, 500)
                    });
                    return;
                }

                if (response.ok && data.success) {
                    showResult('success', 'Upload réussi !', {
                        fileName: data.file_name,
                        message: data.message,
                        fullResponse: data
                    });
                } else {
                    showResult('error', 'Upload échoué', {
                        status: response.status,
                        message: data.message || 'Pas de message d\'erreur',
                        fullResponse: data
                    });
                }

            } catch (error) {
                console.error('Erreur:', error);
                showResult('error', 'Erreur lors de la requête : ' + error.message, {
                    error: error.toString(),
                    stack: error.stack
                });
            }
        }

        async function testRouteAccess() {
            console.log('🔗 Test d\'accessibilité de la route...');
            showResult('info', 'Test en cours...');

            try {
                const response = await fetch('{{ route("regidoc.courriers.scan") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                console.log('Status:', response.status);
                const text = await response.text();
                
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    data = { raw: text.substring(0, 500) };
                }

                showResult('info', 'Route accessible', {
                    status: response.status,
                    statusText: response.statusText,
                    response: data
                });

            } catch (error) {
                showResult('error', 'Route inaccessible : ' + error.message);
            }
        }

        // Log au chargement
        console.log('✅ Page de test chargée');
        console.log('Route à tester:', '{{ route("regidoc.courriers.scan") }}');
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').content);
    </script>
</body>
</html>
