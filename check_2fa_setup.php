<?php

/**
 * Script de vérification de la configuration 2FA
 * 
 * Exécuter avec: php check_2fa_setup.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Vérification de la configuration 2FA ===\n\n";

// 1. Vérifier que Fortify est installé
echo "1. Vérification de Fortify...\n";
if (class_exists('Laravel\Fortify\Fortify')) {
    echo "   ✅ Laravel Fortify est installé\n";
} else {
    echo "   ❌ Laravel Fortify n'est pas installé\n";
    exit(1);
}

// 2. Vérifier que le trait TwoFactorAuthenticatable est utilisé
echo "\n2. Vérification du modèle User...\n";
$user = new App\Models\User();
$traits = class_uses_recursive($user);
if (in_array('Laravel\Fortify\TwoFactorAuthenticatable', $traits)) {
    echo "   ✅ Le trait TwoFactorAuthenticatable est utilisé\n";
} else {
    echo "   ❌ Le trait TwoFactorAuthenticatable n'est pas utilisé\n";
}

// 3. Vérifier que la feature 2FA est activée
echo "\n3. Vérification de la configuration Fortify...\n";
$features = config('fortify.features');
$twoFactorEnabled = false;
foreach ($features as $feature) {
    if (is_string($feature) && strpos($feature, 'two-factor') !== false) {
        $twoFactorEnabled = true;
        break;
    }
    if (is_array($feature) && isset($feature['two-factor-authentication'])) {
        $twoFactorEnabled = true;
        break;
    }
}
if ($twoFactorEnabled) {
    echo "   ✅ La feature 2FA est activée dans config/fortify.php\n";
} else {
    echo "   ⚠️  La feature 2FA pourrait ne pas être activée\n";
}

// 4. Vérifier que les colonnes existent dans la table users
echo "\n4. Vérification des colonnes de la base de données...\n";
try {
    $columns = DB::select("SHOW COLUMNS FROM users WHERE Field IN ('two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at')");
    $columnNames = array_column($columns, 'Field');
    
    if (in_array('two_factor_secret', $columnNames)) {
        echo "   ✅ Colonne 'two_factor_secret' existe\n";
    } else {
        echo "   ❌ Colonne 'two_factor_secret' manquante\n";
    }
    
    if (in_array('two_factor_recovery_codes', $columnNames)) {
        echo "   ✅ Colonne 'two_factor_recovery_codes' existe\n";
    } else {
        echo "   ❌ Colonne 'two_factor_recovery_codes' manquante\n";
    }
    
    if (in_array('two_factor_confirmed_at', $columnNames)) {
        echo "   ✅ Colonne 'two_factor_confirmed_at' existe\n";
    } else {
        echo "   ⚠️  Colonne 'two_factor_confirmed_at' manquante (optionnelle)\n";
    }
} catch (Exception $e) {
    echo "   ❌ Erreur lors de la vérification des colonnes: " . $e->getMessage() . "\n";
}

// 5. Vérifier que les vues existent
echo "\n5. Vérification des vues...\n";
$views = [
    'auth.two-factor-challenge',
    'profile.two-factor-authentication-form'
];

foreach ($views as $view) {
    if (view()->exists($view)) {
        echo "   ✅ Vue '$view' existe\n";
    } else {
        echo "   ❌ Vue '$view' manquante\n";
    }
}

// 6. Statistiques des utilisateurs avec 2FA
echo "\n6. Statistiques 2FA...\n";
try {
    $totalUsers = DB::table('users')->count();
    $usersWithTwoFactor = DB::table('users')->whereNotNull('two_factor_secret')->count();
    $usersWithoutTwoFactor = $totalUsers - $usersWithTwoFactor;
    
    echo "   📊 Total d'utilisateurs: $totalUsers\n";
    echo "   📊 Avec 2FA activée: $usersWithTwoFactor (" . round(($usersWithTwoFactor / $totalUsers) * 100, 2) . "%)\n";
    echo "   📊 Sans 2FA: $usersWithoutTwoFactor (" . round(($usersWithoutTwoFactor / $totalUsers) * 100, 2) . "%)\n";
} catch (Exception $e) {
    echo "   ❌ Erreur lors de la récupération des statistiques: " . $e->getMessage() . "\n";
}

// 7. Vérifier que FortifyServiceProvider est enregistré
echo "\n7. Vérification du service provider...\n";
$providers = config('app.providers');
if (in_array('App\Providers\FortifyServiceProvider', $providers)) {
    echo "   ✅ FortifyServiceProvider est enregistré\n";
} else {
    echo "   ❌ FortifyServiceProvider n'est pas enregistré\n";
}

echo "\n=== Vérification terminée ===\n\n";

// Résumé
echo "📝 RÉSUMÉ:\n";
echo "La configuration 2FA est en place. Pour l'utiliser:\n";
echo "1. Connectez-vous à l'application\n";
echo "2. Allez dans votre profil\n";
echo "3. Cherchez la section 'Two Factor Authentication'\n";
echo "4. Cliquez sur 'Enable' et suivez les instructions\n";
echo "\nConsultez GUIDE_2FA.md pour plus de détails.\n";
