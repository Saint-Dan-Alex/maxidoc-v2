&lt;!DOCTYPE html&gt;
&lt;html lang="fr"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Test Scanner Upload&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Test Upload Scanner&lt;/h1&gt;
    
    &lt;form id="testForm" enctype="multipart/form-data"&gt;
        &lt;input type="file" id="fileInput" accept=".pdf" required&gt;
        &lt;button type="submit"&gt;Tester l'upload&lt;/button&gt;
    &lt;/form&gt;
    
    &lt;div id="result"&gt;&lt;/div&gt;
    
    &lt;script&gt;
        document.getElementById('testForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Veuillez sélectionner un fichier PDF');
                return;
            }
            
            const formData = new FormData();
            formData.append('pdf', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            try {
                console.log('Envoi du fichier:', file.name);
                
                const response = await fetch('/courriers/scan', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                console.log('Status:', response.status);
                console.log('Headers:', Object.fromEntries(response.headers.entries()));
                
                const text = await response.text();
                console.log('Response text:', text);
                
                let data;
                try {
                    data = JSON.parse(text);
                } catch(e) {
                    console.error('Erreur parsing JSON:', e);
                    document.getElementById('result').innerHTML = '&lt;pre&gt;Réponse brute:\n' + text + '&lt;/pre&gt;';
                    return;
                }
                
                document.getElementById('result').innerHTML = '&lt;pre&gt;' + JSON.stringify(data, null, 2) + '&lt;/pre&gt;';
                
                if (data.success) {
                    alert('✅ Upload réussi! Fichier: ' + data.file_name);
                } else {
                    alert('❌ Erreur: ' + (data.message || 'Unknown error'));
                }
            } catch(error) {
                console.error('Erreur:', error);
                document.getElementById('result').innerHTML = '&lt;pre&gt;Erreur: ' + error.message + '&lt;/pre&gt;';
            }
        });
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
