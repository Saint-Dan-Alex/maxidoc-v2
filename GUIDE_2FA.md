# Guide d'utilisation de l'authentification à 2 facteurs (2FA)

## ✅ Configuration actuelle

L'authentification à 2 facteurs est **déjà configurée** dans votre application MAXIDOC grâce à Laravel Fortify.

### Composants installés

1. **Laravel Fortify** - Package d'authentification
2. **Migration de base de données** - Colonnes `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`
3. **Modèle User** - Trait `TwoFactorAuthenticatable` activé
4. **Vues** :
   - Page de gestion 2FA dans le profil utilisateur
   - Page de challenge 2FA lors de la connexion
5. **Configuration** - Feature 2FA activée dans `config/fortify.php`

## 📱 Comment activer la 2FA pour un utilisateur

### Étape 1 : Accéder au profil
1. Connectez-vous à l'application
2. Allez dans **Profil** ou **Paramètres du compte**
3. Cherchez la section **"Two Factor Authentication"** ou **"Authentification à deux facteurs"**

### Étape 2 : Activer la 2FA
1. Cliquez sur le bouton **"Enable"** (Activer)
2. Confirmez votre mot de passe si demandé
3. Un **QR code** s'affiche

### Étape 3 : Scanner le QR code
1. Ouvrez une application d'authentification sur votre téléphone :
   - **Google Authenticator** (Android/iOS)
   - **Microsoft Authenticator** (Android/iOS)
   - **Authy** (Android/iOS)
   - Ou toute autre application TOTP

2. Scannez le QR code affiché
3. L'application génère un code à 6 chiffres qui change toutes les 30 secondes

### Étape 4 : Confirmer l'activation
1. Entrez le code à 6 chiffres généré par votre application
2. Cliquez sur **"Confirm"** (Confirmer)
3. La 2FA est maintenant activée !

### Étape 5 : Sauvegarder les codes de récupération
1. Après confirmation, des **codes de récupération** s'affichent
2. **IMPORTANT** : Sauvegardez ces codes dans un endroit sûr (gestionnaire de mots de passe, coffre-fort numérique)
3. Ces codes permettent de se connecter si vous perdez votre téléphone

## 🔐 Comment se connecter avec la 2FA

### Connexion normale
1. Entrez votre **email** et **mot de passe** comme d'habitude
2. Après validation, une page de **challenge 2FA** s'affiche
3. Ouvrez votre application d'authentification
4. Entrez le **code à 6 chiffres** affiché
5. Cliquez sur **"Log in"** (Se connecter)

### Connexion avec code de récupération
Si vous n'avez pas accès à votre application d'authentification :
1. Sur la page de challenge 2FA, cliquez sur **"Use a recovery code"**
2. Entrez l'un de vos **codes de récupération** sauvegardés
3. Cliquez sur **"Log in"**
4. ⚠️ Chaque code de récupération ne peut être utilisé qu'**une seule fois**

## 🔧 Gestion de la 2FA

### Voir les codes de récupération
1. Allez dans votre profil
2. Section "Two Factor Authentication"
3. Cliquez sur **"Show Recovery Codes"**
4. Confirmez votre mot de passe

### Régénérer les codes de récupération
1. Allez dans votre profil
2. Section "Two Factor Authentication"
3. Cliquez sur **"Regenerate Recovery Codes"**
4. Confirmez votre mot de passe
5. ⚠️ Les anciens codes ne fonctionneront plus

### Désactiver la 2FA
1. Allez dans votre profil
2. Section "Two Factor Authentication"
3. Cliquez sur **"Disable"** (Désactiver)
4. Confirmez votre mot de passe
5. La 2FA est désactivée

## 🚨 En cas de problème

### J'ai perdu mon téléphone et mes codes de récupération
- Contactez un administrateur système
- L'administrateur peut désactiver la 2FA directement dans la base de données :
  ```sql
  UPDATE users 
  SET two_factor_secret = NULL, 
      two_factor_recovery_codes = NULL, 
      two_factor_confirmed_at = NULL 
  WHERE email = 'email@utilisateur.com';
  ```

### Le QR code ne s'affiche pas
- Vérifiez que la migration a été exécutée : `php artisan migrate`
- Videz le cache : `php artisan config:clear && php artisan cache:clear`

### L'application refuse mon code
- Vérifiez que l'heure de votre téléphone est synchronisée (TOTP dépend de l'heure)
- Attendez le prochain code (ils changent toutes les 30 secondes)
- Essayez un code de récupération

## 🔒 Sécurité et bonnes pratiques

1. **Sauvegardez vos codes de récupération** dans un endroit sûr
2. **Ne partagez jamais** vos codes ou QR code
3. **Activez la 2FA** sur tous les comptes administrateurs
4. **Régénérez les codes de récupération** périodiquement
5. **Utilisez une application d'authentification fiable** (Google Authenticator, Microsoft Authenticator, Authy)

## 📊 Pour les administrateurs

### Vérifier si un utilisateur a la 2FA activée
```sql
SELECT id, name, email, 
       CASE WHEN two_factor_secret IS NOT NULL THEN 'Activée' ELSE 'Désactivée' END as statut_2fa
FROM users;
```

### Forcer la désactivation de la 2FA pour un utilisateur
```sql
UPDATE users 
SET two_factor_secret = NULL, 
    two_factor_recovery_codes = NULL, 
    two_factor_confirmed_at = NULL 
WHERE id = [ID_UTILISATEUR];
```

### Statistiques 2FA
```sql
SELECT 
    COUNT(*) as total_utilisateurs,
    SUM(CASE WHEN two_factor_secret IS NOT NULL THEN 1 ELSE 0 END) as avec_2fa,
    SUM(CASE WHEN two_factor_secret IS NULL THEN 1 ELSE 0 END) as sans_2fa
FROM users;
```

## 📝 Notes techniques

- **Algorithme** : TOTP (Time-based One-Time Password)
- **Période** : 30 secondes
- **Longueur du code** : 6 chiffres
- **Fenêtre de tolérance** : Configurable dans `config/fortify.php`
- **Chiffrement** : Les secrets sont chiffrés dans la base de données

## ✅ Checklist de déploiement

- [x] Fortify installé
- [x] Migration exécutée
- [x] Trait TwoFactorAuthenticatable ajouté au modèle User
- [x] Feature activée dans config/fortify.php
- [x] Vues créées (challenge + gestion)
- [x] FortifyServiceProvider enregistré
- [ ] Tester l'activation de la 2FA
- [ ] Tester la connexion avec 2FA
- [ ] Tester les codes de récupération
- [ ] Former les utilisateurs

## 🎯 Prochaines étapes recommandées

1. **Tester le flux complet** :
   - Activer la 2FA sur un compte de test
   - Se déconnecter et se reconnecter avec le code OTP
   - Tester un code de récupération

2. **Former les utilisateurs** :
   - Créer un tutoriel vidéo
   - Envoyer un email explicatif
   - Organiser une session de formation

3. **Rendre la 2FA obligatoire** (optionnel) :
   - Pour les administrateurs
   - Pour tous les utilisateurs après une date donnée
   - Middleware pour forcer l'activation

4. **Monitoring** :
   - Suivre le taux d'adoption de la 2FA
   - Logger les tentatives de connexion échouées
   - Alertes en cas d'utilisation de codes de récupération

---

**Date de création** : 27 octobre 2025  
**Version** : 1.0  
**Application** : MAXIDOC
