# Guide de résolution des problèmes d'upload sur Hostinger

## 📋 Problème
Les uploads d'images et de PDFs fonctionnent en local (WAMP) mais échouent sur Hostinger.

## ✅ Solutions implémentées

### 1. Fichiers modifiés
- ✅ **`app/Http/Controllers/File.php`** : Amélioration de la gestion d'erreurs et compatibilité Hostinger
- ✅ **`app/Http/Controllers/UploadController.php`** : Validation et logs détaillés
- ✅ **`public/diagnostic-storage.php`** : Script de diagnostic créé

### 2. Changements principaux

#### Permissions adaptées à Hostinger
- Changement de `0777` à `0755` pour les dossiers (plus sécurisé et compatible)
- Vérification des permissions avant l'upload
- Logs détaillés pour identifier les problèmes

#### Chemins normalisés
- Utilisation de `/` au lieu de `DIRECTORY_SEPARATOR` 
- Meilleure compatibilité multi-plateforme

#### Validation renforcée
- Vérification de l'existence réelle des fichiers après upload
- Gestion des erreurs avec messages explicites
- Validation des types MIME

## 🔧 Étapes à suivre sur Hostinger

### Étape 1 : Diagnostic
1. Accédez à `http://votre-domaine.com/diagnostic-storage.php`
2. Lisez attentivement les résultats
3. Notez les problèmes identifiés

### Étape 2 : Permissions des dossiers

Connectez-vous en SSH ou via le File Manager de Hostinger et exécutez :

```bash
# Aller dans le dossier de votre application
cd /home/votreuser/domains/votre-domaine.com/public_html

# Corriger les permissions des dossiers storage
chmod 755 storage
chmod 755 storage/app
chmod 755 storage/app/public
chmod -R 755 storage/logs
chmod -R 755 storage/framework

# Créer les dossiers manquants s'ils n'existent pas
mkdir -p storage/app/public/documents
mkdir -p storage/app/public/tmp
mkdir -p storage/app/public/pieces-jointes

# Appliquer les permissions
chmod -R 755 storage/app/public
```

### Étape 3 : Créer le lien symbolique

```bash
# Supprimer l'ancien lien s'il existe
rm -rf public/storage

# Créer le nouveau lien
php artisan storage:link
```

**⚠️ Important** : Si la commande `php artisan storage:link` échoue, créez le lien manuellement :

```bash
ln -s /home/votreuser/domains/votre-domaine.com/public_html/storage/app/public /home/votreuser/domains/votre-domaine.com/public_html/public/storage
```

### Étape 4 : Configuration PHP

Vérifiez dans le panneau Hostinger (ou via `.htaccess` / `php.ini`) :

```ini
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
memory_limit = 256M
```

### Étape 5 : Fichier .htaccess (optionnel)

Si vous avez toujours des problèmes, ajoutez dans `public/.htaccess` :

```apache
# Permissions d'upload
php_value upload_max_filesize 20M
php_value post_max_size 25M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Étape 6 : Vérifier les logs Laravel

```bash
# Voir les derniers logs
tail -f storage/logs/laravel.log

# Ou via Hostinger File Manager
# Aller dans storage/logs/ et ouvrir laravel.log
```

## 🐛 Problèmes courants et solutions

### Erreur : "Impossible de créer le répertoire"

**Cause** : Permissions insuffisantes

**Solution** :
```bash
chmod -R 755 storage/app/public
chown -R votreuser:votreuser storage/
```

### Erreur : "Le lien symbolique n'existe pas"

**Cause** : Le lien `public/storage` → `storage/app/public` n'est pas créé

**Solution** :
```bash
php artisan storage:link
# OU
ln -s ../storage/app/public public/storage
```

### Erreur : "File not found" après upload

**Cause** : Le fichier est uploadé mais le chemin est incorrect

**Solution** : Vérifiez que :
1. Le lien symbolique existe
2. L'URL dans `.env` est correcte : `APP_URL=https://votre-domaine.com`
3. Les chemins dans la base de données ne commencent pas par `/`

### Erreur : "413 Request Entity Too Large"

**Cause** : Limite de taille de fichier dépassée

**Solution** : Augmentez les limites dans Hostinger :
- Via le panneau : PHP Configuration → upload_max_filesize
- Via `.htaccess` (voir Étape 5)

### Erreur : "Permission denied"

**Cause** : Le serveur web n'a pas les droits d'écriture

**Solution** :
```bash
# Vérifier le propriétaire
ls -la storage/

# Changer le propriétaire si nécessaire (remplacez votreuser)
chown -R votreuser:votreuser storage/
chmod -R 755 storage/
```

## 📊 Tests après correction

1. **Test via le script de diagnostic** :
   - Accédez à `http://votre-domaine.com/diagnostic-storage.php`
   - Tous les tests doivent être ✅

2. **Test d'upload réel** :
   - Essayez d'uploader une image (< 2MB)
   - Essayez d'uploader un PDF (< 5MB)
   - Vérifiez dans `storage/app/public/` que les fichiers sont présents

3. **Vérification des logs** :
   ```bash
   tail -20 storage/logs/laravel.log
   ```
   - Cherchez les messages `Fichier stocké avec succès`
   - Vérifiez qu'il n'y a pas d'erreurs

## 🔐 Sécurité sur Hostinger

### Permissions recommandées
- **Dossiers** : `755` (rwxr-xr-x)
- **Fichiers** : `644` (rw-r--r--)
- **Fichiers sensibles** (.env) : `600` (rw-------)

### Appliquer les bonnes permissions
```bash
# Dossiers
find storage -type d -exec chmod 755 {} \;

# Fichiers
find storage -type f -exec chmod 644 {} \;

# Fichier .env
chmod 600 .env
```

## 📞 Support Hostinger

Si aucune de ces solutions ne fonctionne :

1. **Contactez le support Hostinger** avec :
   - Les résultats du script `diagnostic-storage.php`
   - Les dernières lignes de `storage/logs/laravel.log`
   - Les permissions actuelles de vos dossiers

2. **Vérifications par le support** :
   - Open_basedir restrictions
   - Suhosin patches
   - Mod_security rules
   - Limitations spécifiques au compte

## 📝 Checklist finale

- [ ] Script `diagnostic-storage.php` exécuté et analysé
- [ ] Permissions `755` appliquées sur `storage/`
- [ ] Lien symbolique `public/storage` créé et fonctionnel
- [ ] Configuration PHP correcte (upload_max_filesize, etc.)
- [ ] Tests d'upload réussis pour images et PDFs
- [ ] Logs Laravel sans erreurs
- [ ] Fichiers visibles dans `storage/app/public/`
- [ ] Accès aux fichiers via URL (https://domaine.com/storage/...)

## 🎯 Résultat attendu

Après avoir suivi toutes ces étapes :
- ✅ Upload d'images fonctionne
- ✅ Upload de PDFs fonctionne
- ✅ Pas d'erreurs dans les logs
- ✅ Fichiers accessibles via l'application
- ✅ Permissions sécurisées

---

**Date de création** : 2025-01-21  
**Version** : 1.0  
**Application** : Maxidoc
