# Guide de test - Authentification à 2 facteurs

## 🚀 Étapes pour tester la 2FA

### 1. Préparer l'environnement

```bash
# Exécuter la migration
php artisan migrate

# Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 2. Tester le flux complet

#### Étape 1: Aller sur la page de login
```
URL: https://maxidoc-lp.newtech-rdc.net/login
```

#### Étape 2: Se connecter avec vos identifiants
- **Email**: votre_email@example.com
- **Mot de passe**: votre_mot_de_passe

#### Étape 3: Vérifier la redirection
Après avoir cliqué sur "Se connecter", vous devriez être automatiquement redirigé vers:
```
URL: https://maxidoc-lp.newtech-rdc.net/authentification/two-factor/challenge
```

#### Étape 4: Vérifier la réception de l'email
- Ouvrez votre boîte email
- Vous devriez recevoir un email avec le sujet: **"Votre code d'authentification à deux facteurs"**
- L'email contient un code à 6 chiffres

#### Étape 5: Saisir le code
- Sur la page de challenge, vous verrez 6 champs séparés
- Saisissez chaque chiffre du code reçu par email
- Le curseur se déplace automatiquement au champ suivant
- Le bouton "Vérifier" s'active automatiquement quand les 6 chiffres sont saisis

#### Étape 6: Valider
- Cliquez sur "Vérifier" (ou appuyez sur Entrée)
- Si le code est correct, vous serez connecté et redirigé vers le tableau de bord

## 🧪 Tests supplémentaires

### Test 1: Code invalide
1. Saisissez un code incorrect (ex: 000000)
2. Cliquez sur "Vérifier"
3. **Résultat attendu**: Message d'erreur "Le code est invalide ou a expiré."

### Test 2: Renvoi du code
1. Sur la page de challenge, cliquez sur "Vous n'avez pas reçu le code ? Renvoyer"
2. **Résultat attendu**: 
   - Message de confirmation "Un nouveau code a été envoyé à votre adresse email."
   - Réception d'un nouvel email avec un nouveau code

### Test 3: Code expiré
1. Attendez 10 minutes après avoir reçu le code
2. Essayez de valider le code
3. **Résultat attendu**: Message d'erreur "Le code est invalide ou a expiré."

### Test 4: Copier-coller
1. Copiez le code à 6 chiffres depuis l'email
2. Cliquez sur le premier champ de saisie
3. Collez le code (Ctrl+V)
4. **Résultat attendu**: Les 6 chiffres se répartissent automatiquement dans les 6 champs

### Test 5: Navigation au clavier
1. Utilisez les touches fléchées pour naviguer entre les champs
2. Utilisez Backspace pour revenir au champ précédent
3. **Résultat attendu**: Navigation fluide entre les champs

## 🔍 Vérifications techniques

### Vérifier que l'email est envoyé

```bash
# Vérifier les logs Laravel
tail -f storage/logs/laravel.log

# Chercher les entrées contenant "Code 2FA envoyé"
```

### Vérifier la session

```bash
# En local, vous pouvez utiliser Tinker
php artisan tinker

# Vérifier la session
session()->all()
```

### Vérifier la base de données

```sql
-- Vérifier qu'un utilisateur a reçu un code
SELECT id, email, two_factor_email_code, two_factor_expires_at 
FROM users 
WHERE email = 'votre_email@example.com';

-- Le two_factor_email_code doit être hashé (commence par $2y$)
-- Le two_factor_expires_at doit être dans le futur (< 10 minutes)
```

## 🐛 Dépannage

### Problème: L'email n'est pas envoyé

**Solution 1: Vérifier la configuration email**
```bash
# Vérifier le fichier .env
cat .env | grep MAIL_
```

**Solution 2: Tester l'envoi d'email manuellement**
```bash
php artisan tinker

# Dans Tinker:
$user = User::first();
$user->notify(new \App\Notifications\TwoFactorEmailCode('123456'));
```

**Solution 3: Vérifier les logs**
```bash
tail -f storage/logs/laravel.log
```

### Problème: Redirection ne fonctionne pas

**Solution: Vérifier les routes**
```bash
php artisan route:list | grep two-factor
```

Vous devriez voir:
```
POST   | authentification/two-factor/verify    | auth.two-factor.verify
GET    | authentification/two-factor/challenge | auth.two-factor.challenge
GET    | authentification/two-factor/resend    | auth.two-factor.resend
```

### Problème: Code toujours invalide

**Solution: Vérifier le code en base**
```bash
php artisan tinker

# Dans Tinker:
$user = User::where('email', 'votre_email@example.com')->first();
$code = decrypt($user->two_factor_secret);
echo $code;
```

### Problème: Session perdue

**Solution: Vérifier la configuration session**
```bash
# Dans .env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## 📊 Checklist de test

- [ ] Login normal fonctionne
- [ ] Redirection vers la page de challenge
- [ ] Email reçu avec le code
- [ ] Code à 6 chiffres visible dans l'email
- [ ] Page de challenge s'affiche correctement
- [ ] 6 champs de saisie fonctionnent
- [ ] Navigation automatique entre les champs
- [ ] Bouton "Vérifier" s'active après saisie
- [ ] Code valide permet la connexion
- [ ] Code invalide affiche une erreur
- [ ] Bouton "Renvoyer" fonctionne
- [ ] Nouveau code reçu après renvoi
- [ ] Code expire après 10 minutes
- [ ] Copier-coller fonctionne
- [ ] Design responsive (mobile)

## 🎯 Scénario de test complet

```
1. Ouvrir https://maxidoc-lp.newtech-rdc.net/login
2. Saisir email: admin@maxidoc.com
3. Saisir mot de passe: ********
4. Cliquer sur "Se connecter"
5. ✅ Vérifier: Redirection vers /authentification/two-factor/challenge
6. ✅ Vérifier: Email reçu dans la boîte de réception
7. Copier le code depuis l'email (ex: 123456)
8. Coller le code dans le premier champ
9. ✅ Vérifier: Les 6 chiffres se répartissent automatiquement
10. Cliquer sur "Vérifier"
11. ✅ Vérifier: Connexion réussie et redirection vers le tableau de bord
12. ✅ Vérifier: Utilisateur connecté (nom affiché en haut à droite)
```

## 📝 Notes importantes

1. **La 2FA est activée pour TOUS les utilisateurs** par défaut
   - Pour désactiver pour certains utilisateurs, modifiez `AuthController::isTwoFactorEnabled()`

2. **Le code expire après 10 minutes**
   - Pour modifier, changez dans `TwoFactorAuthService.php` ligne 30

3. **Maximum 5 tentatives par minute**
   - Rate limiting configuré dans `FortifyServiceProvider.php`

4. **Les codes sont hashés en base de données**
   - Sécurité: impossible de récupérer le code en clair

5. **Session nécessaire**
   - L'email est stocké en session pour la validation
   - Si la session expire, l'utilisateur doit se reconnecter

## 🔗 URLs importantes

- **Page de login**: `/login`
- **Page de challenge 2FA**: `/authentification/two-factor/challenge`
- **Vérification du code**: `/authentification/two-factor/verify` (POST)
- **Renvoi du code**: `/authentification/two-factor/resend`

## 📞 Support

En cas de problème:
1. Vérifier les logs: `storage/logs/laravel.log`
2. Vérifier la configuration email dans `.env`
3. Tester l'envoi d'email manuellement avec Tinker
4. Vérifier que la migration a été exécutée
5. Vider tous les caches

---

**Bon test! 🚀**
