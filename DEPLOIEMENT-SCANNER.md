# GUIDE DE DÉPLOIEMENT - CORRECTION SCANNER MAXIDOC
# Date: 2024-11-28

## ⚠️ PROBLÈME ACTUEL
Le scanner ne sauvegarde pas les documents. Erreur: "Réponse vide ou nulle"

## 📋 FICHIERS À DÉPLOYER (dans l'ordre)

### 1. routes/web.php
**Ligne 272** doit contenir:
```php
Route::post('courriers/scan', [CourrierController::class, 'scan'])->name('courriers.scan');
```

### 2. resources/views/livewire/courrier/add-courrier-form.blade.php
**Ligne 707** doit contenir:
```javascript
"url": "{{ route('regidoc.courriers.scan') }}",
```

**Ligne 698** doit contenir (pour vérifier le déploiement):
```javascript
console.log('✅ FICHIER BLADE CHARGE - Version 2024-11-28-16h15');
```

### 3. app/Http/Controllers/Courriers/CourrierController.php
**Ligne 2700** doit contenir:
```php
\Log::info('🔍 scan() appelée', [
```

## 🚀 MÉTHODE DE DÉPLOIEMENT

### Option A: Via FTP/SFTP (RECOMMANDÉ)
1. Ouvrez FileZilla ou WinSCP
2. Connectez-vous à: 82.25.113.217:65002
3. Uploadez les 3 fichiers ci-dessus vers:
   - /home/u115315654/domains/maxidoc-lp.newtech-rdc.net/routes/web.php
   - /home/u115315654/domains/maxidoc-lp.newtech-rdc.net/resources/views/livewire/courrier/add-courrier-form.blade.php
   - /home/u115315654/domains/maxidoc-lp.newtech-rdc.net/app/Http/Controllers/Courriers/CourrierController.php

### Option B: Via cPanel File Manager
1. Connectez-vous à votre cPanel
2. Ouvrez "File Manager"
3. Naviguez vers /home/u115315654/domains/maxidoc-lp.newtech-rdc.net/
4. Uploadez ou éditez les 3 fichiers

### Option C: Via Git (si configuré)
```bash
# Sur votre machine locale
git add .
git commit -m "Fix: Scanner upload avec logs détaillés"
git push

# Sur le serveur (via SSH ou cPanel Terminal)
cd /home/u115315654/domains/maxidoc-lp.newtech-rdc.net
git pull
```

## 🧹 APRÈS LE DÉPLOIEMENT

### 1. Vider le cache
Accédez à cette URL dans votre navigateur:
```
https://maxidoc-lp.newtech-rdc.net/clear-all-cache-temp-2024
```

Vous devriez voir:
```json
{"success":true,"message":"Cache vidé avec succès!"}
```

### 2. Vérifier le déploiement
1. Ouvrez: https://maxidoc-lp.newtech-rdc.net/courriers/nouveau
2. Appuyez sur F12 (outils développeur)
3. Allez dans l'onglet "Console"
4. Rafraîchissez la page (F5)
5. Vous DEVEZ voir: "✅ FICHIER BLADE CHARGE - Version 2024-11-28-16h15"

❌ Si vous ne voyez PAS ce message → Le fichier Blade n'est pas déployé
✅ Si vous voyez ce message → Le déploiement a réussi

### 3. Tester le scanner
1. Cliquez sur "Numériser à partir d'un scanner"
2. Dans la console, vous devriez voir:
   - 🔍 Initialisation du scan
   - 📍 URL d'upload: ...
   - 🔑 CSRF Token: ...
3. Scannez un document
4. Dans la console, vous devriez voir:
   - 📥 displayServerResponse appelée
   - ✅ Successful: true/false
   - 📦 Response: ...

## 📊 CONSULTER LES LOGS

### Sur le serveur
Fichier: `/home/u115315654/domains/maxidoc-lp.newtech-rdc.net/storage/logs/laravel.log`

Cherchez les lignes avec:
- 🔍 scan() appelée
- ✅ Fichier trouvé
- 🎉 Scan réussi

### Si aucun log n'apparaît
→ La requête n'atteint pas le serveur
→ Problème de réseau ou de configuration du scanner Asprise

## 🆘 DÉPANNAGE

### Problème: "Réponse vide ou nulle"
**Cause possible:**
1. Le fichier Blade n'est pas déployé → Vérifier étape 2
2. Le cache n'est pas vidé → Vider le cache
3. La route n'existe pas → Vérifier routes/web.php ligne 272
4. Le scanner Asprise ne peut pas atteindre le serveur → Problème réseau/CORS

### Problème: Rien dans les logs Laravel
**Cause:**
- La requête n'atteint jamais le serveur
- Vérifier l'URL dans la console JavaScript
- Vérifier que la route existe: `php artisan route:list | grep scan`

### Problème: Le fichier ne se sauvegarde pas
**Cause:**
- Permissions du dossier storage/public/tmp_scanne
- Exécuter: `chmod -R 775 storage public/storage`
- Créer le dossier: `mkdir -p public/storage/tmp_scanne`

## ✅ CHECKLIST FINALE

- [ ] Fichier routes/web.php déployé
- [ ] Fichier add-courrier-form.blade.php déployé
- [ ] Fichier CourrierController.php déployé
- [ ] Cache vidé (URL /clear-all-cache-temp-2024)
- [ ] Message de version visible dans la console
- [ ] Scanner s'ouvre correctement
- [ ] Logs JavaScript visibles dans la console
- [ ] Logs Laravel visibles dans laravel.log
- [ ] Document scanné sauvegardé dans storage/public/tmp_scanne

## 📞 SUPPORT

Si le problème persiste après avoir suivi TOUTES ces étapes:
1. Faites une capture d'écran de la console JavaScript
2. Copiez les 50 dernières lignes du fichier laravel.log
3. Vérifiez que le message "✅ FICHIER BLADE CHARGE" apparaît
