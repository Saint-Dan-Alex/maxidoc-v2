<?php
// test_upload.php
// Placez ce fichier dans le dossier public_html de votre serveur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Upload Scan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .result { margin-top: 20px; padding: 10px; border: 1px solid #ccc; background: #f9f9f9; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Test de l'Upload Scan (Simulation)</h1>
    <p>Ce formulaire simule l'envoi d'un fichier PDF vers la route de scan.</p>
    
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="pdf" id="pdfFile" accept=".pdf" required>
        <br><br>
        <!-- On récupère le token CSRF depuis une meta tag si on était dans Laravel, mais ici on est hors framework -->
        <!-- On va essayer de faire l'appel Ajax qui inclura les cookies de session -->
        <button type="submit">Envoyer le fichier</button>
    </form>

    <div id="result" class="result">En attente...</div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData();
            var fileInput = document.getElementById('pdfFile');
            formData.append('pdf', fileInput.files[0]);
            
            // Tenter de récupérer le token CSRF si possible (difficile depuis un fichier externe)
            // Si vous êtes connecté à l'appli, le cookie XSRF-TOKEN devrait être présent
            
            var resultDiv = document.getElementById('result');
            resultDiv.innerHTML = 'Envoi en cours...';
            
            // L'URL de la route scan
            var uploadUrl = '/courriers/scan'; // Chemin relatif, suppose que le script est à la racine du site
            
            fetch(uploadUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    // On essaie de lire le token XSRF depuis les cookies pour le header
                    'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
                }
            })
            .then(response => {
                resultDiv.innerHTML = 'Statut: ' + response.status + ' ' + response.statusText + '<br>';
                return response.text().then(text => {
                    resultDiv.innerHTML += '<strong>Réponse brute:</strong> <pre>' + text + '</pre>';
                    try {
                        var json = JSON.parse(text);
                        resultDiv.innerHTML += '<div class="success">JSON valide détecté!</div>';
                        console.log(json);
                    } catch (e) {
                        resultDiv.innerHTML += '<div class="error">Ce n\'est pas du JSON valide.</div>';
                    }
                });
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="error">Erreur réseau: ' + error.message + '</div>';
            });
        });

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return decodeURIComponent(parts.pop().split(";").shift());
        }
    </script>
</body>
</html>
