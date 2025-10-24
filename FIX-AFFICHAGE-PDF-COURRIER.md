# Correction de l'affichage du PDF dans show-courrier.blade.php

## Problème identifié

Le fichier `resources/views/regidoc/pages/courriers/show-courrier.blade.php` n'affichait ni le nom ni le contenu du PDF, bien que le document existe dans la base de données.

### Causes principales

1. **Variable `$documentUrl` non définie** (ligne 1068)
   - L'iframe utilisait une variable `$documentUrl` qui n'était jamais créée
   - Cela causait une erreur PHP et empêchait l'affichage du PDF

2. **Gestion insuffisante des cas d'erreur**
   - Pas de vérification si le helper `files()` retournait un objet vide
   - Pas de message d'erreur si le fichier n'existe pas physiquement

## Solutions appliquées

### 1. Correction de la section PHP (lignes 356-386)

**Avant:**
```php
if ($courrier->traitements->count() && $courrier->traitements->last()->document_url) {
    $docToShow = str_replace('\\', '/', files($courrier->traitements->last()->document_url)->link);
    $nameDocToShow = files($courrier->traitements->last()->document_url)->name;
} elseif ($courrier->document?->document) {
    $docToShow = str_replace('\\', '/', files($courrier->document->document)->link);
    $nameDocToShow = files($courrier->document->document)->name;
    $docToShowId = $courrier->document->id;
}
```

**Après:**
```php
if ($courrier->traitements->count() && $courrier->traitements->last()->document_url) {
    $fileObj = files($courrier->traitements->last()->document_url);
    if ($fileObj && !empty($fileObj->link)) {
        $docToShow = str_replace('\\', '/', $fileObj->link);
        $nameDocToShow = $fileObj->name;
    }
} elseif ($courrier->document?->document) {
    $fileObj = files($courrier->document->document);
    if ($fileObj && !empty($fileObj->link)) {
        $docToShow = str_replace('\\', '/', $fileObj->link);
        $nameDocToShow = $fileObj->name;
        $docToShowId = $courrier->document->id;
    }
}
```

**Améliorations:**
- Vérification que `$fileObj` n'est pas vide avant d'accéder à ses propriétés
- Évite les erreurs si le fichier n'existe pas dans le stockage

### 2. Correction de l'affichage du PDF (lignes 1055-1084)

**Avant:**
```blade
<div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
    @php
        $documentPath = $courrier->document?->document;
        $storagePath = $documentPath ? storage_path('app/' . $documentPath) : null;
        $publicPath = $documentPath ? 'storage/' . $documentPath : null;
        $fileExists = $storagePath && file_exists($storagePath);
    @endphp

    @if($courrier->document && $courrier->document->document && $fileExists)
        <iframe src="{{ $documentUrl }}" frameborder="0" style="width: 100%; height: 100%; min-height: 80vh;"></iframe>
    @endif
</div>
```

**Après:**
```blade
<div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
    @php
        $documentPath = $courrier->document?->document;
        $storagePath = $documentPath ? storage_path('app/' . $documentPath) : null;
        $fileExists = $storagePath && file_exists($storagePath);
        
        // Construire l'URL du document
        $documentUrl = '';
        if ($fileExists && $documentPath) {
            $documentUrl = asset('storage/' . $documentPath) . '#toolbar=0&navpanes=0&page=1';
        }
    @endphp

    @if($courrier->document && $courrier->document->document && $fileExists)
        <div style="text-align: center; padding: 10px; background: #f5f5f5;">
            <strong>Document:</strong> {{ $courrier->document->libelle ?? 'Document du courrier' }}
        </div>
        <iframe src="{{ $documentUrl }}" frameborder="0" style="width: 100%; height: 100%; min-height: 80vh;"></iframe>
    @else
        <div style="text-align: center; padding: 50px; color: #999;">
            <i class="fi fi-rr-file-pdf" style="font-size: 48px;"></i>
            <p>Aucun document disponible</p>
            @if($courrier->document)
                <small>Chemin: {{ $courrier->document->document }}</small>
            @endif
        </div>
    @endif
</div>
```

**Améliorations:**
- Définition correcte de `$documentUrl` avec le chemin complet
- Ajout d'un en-tête affichant le nom du document
- Message d'erreur clair si le document n'existe pas
- Affichage du chemin du document pour faciliter le débogage

### 3. Ajout d'informations de debug (lignes 388-396)

```blade
@if(config('app.debug'))
    <div class="alert alert-info" style="margin: 10px;">
        <strong>Debug Info:</strong>
        <pre>@php print_r($debugInfo) @endphp</pre>
        <p><strong>URL du document:</strong> {{ $docToShow ?: 'Vide' }}</p>
        <p><strong>Nom du document:</strong> {{ $nameDocToShow ?: 'Vide' }}</p>
    </div>
@endif
```

**Avantages:**
- Visible uniquement en mode développement (`APP_DEBUG=true`)
- Permet de diagnostiquer rapidement les problèmes de chemin
- Affiche toutes les informations pertinentes sur le document

## Fonctionnement du helper `files()`

Le helper `files()` (défini dans `app/Helpers/Helpers.php`) :
- Prend en entrée un champ JSON ou une chaîne représentant un fichier
- Vérifie que le fichier existe dans `storage/app/public`
- Retourne un objet avec `link` (URL publique) et `name` (nom du fichier)
- Retourne un objet vide si le fichier n'existe pas

### 4. Ajout d'une logique de secours (lignes 374-408)

Si le helper `files()` échoue (fichier n'existe pas dans storage), une logique de secours construit l'URL manuellement :

```php
// Récupérer le chemin brut du document
$rawDocPath = $courrier->document->document;

// Essayer d'abord avec le helper files()
$fileObj = files($rawDocPath);
if ($fileObj && !empty($fileObj->link)) {
    $docToShow = str_replace('\\', '/', $fileObj->link);
    $nameDocToShow = $fileObj->name;
    $docToShowId = $courrier->document->id;
} else {
    // Si le helper files() échoue, essayer de construire l'URL manuellement
    $decoded = json_decode($rawDocPath);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded[0]->download_link)) {
        $downloadLink = $decoded[0]->download_link;
        $downloadLink = str_replace(['\\/', '\\\\', '\\'], '/', $downloadLink);
        $downloadLink = preg_replace('#^[/]+#', '', $downloadLink);
        $downloadLink = preg_replace('#^storage[/]#i', '', $downloadLink);
        
        $docToShow = asset('storage/' . $downloadLink);
        $nameDocToShow = $decoded[0]->original_name ?? basename($downloadLink);
        $docToShowId = $courrier->document->id;
    } elseif (is_string($rawDocPath)) {
        // Si c'est une chaîne simple, l'utiliser directement
        $cleanPath = str_replace(['\\/', '\\\\', '\\'], '/', $rawDocPath);
        $cleanPath = preg_replace('#^[/]+#', '', $cleanPath);
        $cleanPath = preg_replace('#^storage[/]#i', '', $cleanPath);
        
        $docToShow = asset('storage/' . $cleanPath);
        $nameDocToShow = basename($cleanPath);
        $docToShowId = $courrier->document->id;
    }
}
```

**Avantages :**
- Fonctionne même si le fichier n'est pas vérifié par `files()`
- Gère les différents formats de stockage (JSON, chaîne simple)
- Normalise automatiquement les chemins avec backslashes

### 5. Simplification de l'affichage du PDF (lignes 1067-1070)

Le conteneur `#pdf-contents` est maintenant vide et laisse le script `showPDF.js` gérer l'affichage :

```blade
{{-- Le conteneur sera rempli par le script showPDF.js --}}
<div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
    {{-- Le script showPDF.js va injecter le contenu ici --}}
</div>
```

### 6. Ajout de debug dans la console (lignes 2621-2639)

```javascript
console.group('📄 Debug Info - Courrier #{{ $courrier->id }}');
console.log('Document exists:', {{ $courrier->document ? 'true' : 'false' }});
console.log('Document path:', '{{ $courrier->document?->document ?? "N/A" }}');
console.log('URL to show:', '{{ $docToShow }}');
console.log('Document name:', '{{ $nameDocToShow }}');
console.log('Document ID:', '{{ $docToShowId }}');

@if(empty($docToShow))
    console.error('⚠️ ATTENTION: L\'URL du document est vide!');
@endif
console.groupEnd();
```

## Test de la correction

Pour tester la correction :

1. Ouvrir la console du navigateur (F12)

2. Accéder à un courrier avec un document :
   ```
   http://127.0.0.1:8000/courriers/9
   ```

3. Vérifier dans la console :
   - Les informations de debug s'affichent
   - L'URL du document est correcte
   - Aucune erreur JavaScript

4. Vérifier dans la page :
   - Le PDF se charge correctement
   - Le script showPDF.js affiche le document avec les canvas
   - Les outils PDF (zoom, navigation) fonctionnent

## Fichiers modifiés

- `resources/views/regidoc/pages/courriers/show-courrier.blade.php`

## Notes importantes

- Le champ `document` dans la table `documents` contient du JSON
- Le helper `files()` gère automatiquement la normalisation des chemins
- En production, mettre `APP_DEBUG=false` pour masquer les informations de debug
