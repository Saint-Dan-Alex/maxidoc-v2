<?php
/**
 * Script de diagnostic des problèmes d'upload sur Hostinger
 * À placer dans le dossier public/ et accéder via : http://votre-domaine.com/diagnostic-storage.php
 */

echo "<h1>Diagnostic du système de stockage - Maxidoc</h1>";
echo "<hr>";

// 1. Vérifier les chemins
echo "<h2>1. Vérification des chemins</h2>";
$paths = [
    'Base Path' => base_path(),
    'Storage Path' => storage_path(),
    'Storage App' => storage_path('app'),
    'Storage Public' => storage_path('app/public'),
    'Public Path' => public_path(),
    'Public Storage Link' => public_path('storage'),
];

foreach ($paths as $label => $path) {
    $exists = file_exists($path);
    $writable = is_writable($path);
    $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
    
    echo "<p><strong>$label:</strong><br>";
    echo "Chemin: $path<br>";
    echo "Existe: " . ($exists ? '✅ Oui' : '❌ Non') . "<br>";
    echo "Permissions: $perms<br>";
    echo "Écriture: " . ($writable ? '✅ Oui' : '❌ Non') . "</p>";
}

// 2. Vérifier le lien symbolique
echo "<h2>2. Vérification du lien symbolique</h2>";
$storageLink = public_path('storage');
if (is_link($storageLink)) {
    echo "<p>✅ Le lien symbolique existe</p>";
    echo "<p>Cible: " . readlink($storageLink) . "</p>";
} else if (file_exists($storageLink)) {
    echo "<p>⚠️ Un dossier 'storage' existe mais ce n'est pas un lien symbolique</p>";
} else {
    echo "<p>❌ Le lien symbolique n'existe pas</p>";
    echo "<p><strong>Solution:</strong> Exécutez <code>php artisan storage:link</code></p>";
}

// 3. Configuration PHP
echo "<h2>3. Configuration PHP</h2>";
$phpConfig = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_execution_time' => ini_get('max_execution_time'),
    'memory_limit' => ini_get('memory_limit'),
    'file_uploads' => ini_get('file_uploads') ? 'Activé' : 'Désactivé',
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: sys_get_temp_dir(),
];

foreach ($phpConfig as $key => $value) {
    echo "<p><strong>$key:</strong> $value</p>";
}

// Vérifier si le dossier temp est accessible
$tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
$tmpWritable = is_writable($tmpDir);
echo "<p><strong>Dossier temp accessible:</strong> " . ($tmpWritable ? '✅ Oui' : '❌ Non') . "</p>";

// 4. Test d'écriture
echo "<h2>4. Test d'écriture dans storage</h2>";
$testDirs = [
    storage_path('app/public'),
    storage_path('app/public/documents'),
    storage_path('app/public/tmp'),
];

foreach ($testDirs as $dir) {
    // Créer le dossier s'il n'existe pas
    if (!file_exists($dir)) {
        $created = @mkdir($dir, 0755, true);
        echo "<p>Création de $dir: " . ($created ? '✅ Succès' : '❌ Échec') . "</p>";
    }
    
    if (file_exists($dir)) {
        $testFile = $dir . '/test_' . time() . '.txt';
        $written = @file_put_contents($testFile, 'Test d\'écriture');
        
        if ($written !== false) {
            echo "<p>✅ Écriture réussie dans $dir</p>";
            @unlink($testFile); // Supprimer le fichier de test
        } else {
            echo "<p>❌ Impossible d'écrire dans $dir</p>";
        }
    }
}

// 5. Vérification des propriétaires et groupes (important sur Hostinger)
echo "<h2>5. Propriétaires des dossiers</h2>";
$checkDirs = [
    storage_path('app'),
    storage_path('app/public'),
    public_path('storage'),
];

foreach ($checkDirs as $dir) {
    if (file_exists($dir)) {
        $stat = stat($dir);
        $owner = posix_getpwuid($stat['uid']);
        $group = posix_getgrgid($stat['gid']);
        
        echo "<p><strong>$dir</strong><br>";
        echo "Propriétaire: " . ($owner['name'] ?? $stat['uid']) . "<br>";
        echo "Groupe: " . ($group['name'] ?? $stat['gid']) . "<br>";
        echo "Permissions: " . substr(sprintf('%o', fileperms($dir)), -4) . "</p>";
    }
}

// 6. Variables d'environnement Laravel
echo "<h2>6. Configuration Laravel</h2>";
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "<p><strong>APP_ENV:</strong> " . env('APP_ENV', 'N/A') . "</p>";
    echo "<p><strong>APP_URL:</strong> " . env('APP_URL', 'N/A') . "</p>";
    echo "<p><strong>FILESYSTEM_DISK:</strong> " . env('FILESYSTEM_DISK', 'local') . "</p>";
    
} catch (Exception $e) {
    echo "<p>⚠️ Impossible de charger la configuration Laravel: " . $e->getMessage() . "</p>";
}

// 7. Recommandations
echo "<h2>7. Recommandations pour Hostinger</h2>";
echo "<ul>";
echo "<li>Les permissions recommandées : 755 pour les dossiers, 644 pour les fichiers</li>";
echo "<li>Créez le lien symbolique : <code>php artisan storage:link</code></li>";
echo "<li>Vérifiez que tous les dossiers dans storage/ ont les bonnes permissions</li>";
echo "<li>Sur Hostinger, le propriétaire doit être votre utilisateur FTP</li>";
echo "<li>Si les problèmes persistent, contactez le support Hostinger pour vérifier les restrictions</li>";
echo "</ul>";

echo "<hr>";
echo "<p><em>Diagnostic généré le " . date('Y-m-d H:i:s') . "</em></p>";
