#!/bin/bash

# Script de correction automatique des permissions pour Hostinger
# Usage: bash fix-permissions-hostinger.sh

echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║   Script de correction des permissions - Maxidoc/Hostinger   ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonction pour afficher les messages
print_success() {
    echo -e "${GREEN}✓${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_info() {
    echo -e "ℹ $1"
}

# Vérifier qu'on est dans le bon dossier
if [ ! -f "artisan" ]; then
    print_error "Ce script doit être exécuté depuis la racine de votre application Laravel"
    exit 1
fi

print_success "Application Laravel détectée"
echo ""

# 1. Créer les dossiers manquants
echo "📁 Création des dossiers manquants..."

directories=(
    "storage/app/public"
    "storage/app/public/documents"
    "storage/app/public/tmp"
    "storage/app/public/pieces-jointes"
    "storage/app/public/courrier-traitements"
    "storage/framework/cache"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/logs"
)

for dir in "${directories[@]}"; do
    if [ ! -d "$dir" ]; then
        mkdir -p "$dir" 2>/dev/null
        if [ $? -eq 0 ]; then
            print_success "Créé: $dir"
        else
            print_error "Impossible de créer: $dir"
        fi
    else
        print_info "Existe déjà: $dir"
    fi
done

echo ""

# 2. Appliquer les permissions
echo "🔐 Application des permissions..."

# Permissions sur storage
chmod 755 storage 2>/dev/null && print_success "Permissions sur storage/" || print_error "Échec permissions storage/"
chmod 755 storage/app 2>/dev/null && print_success "Permissions sur storage/app/" || print_error "Échec permissions storage/app/"
chmod 755 storage/app/public 2>/dev/null && print_success "Permissions sur storage/app/public/" || print_error "Échec permissions storage/app/public/"

# Permissions récursives
chmod -R 755 storage/app/public 2>/dev/null && print_success "Permissions récursives sur storage/app/public/" || print_warning "Certaines permissions n'ont pas pu être appliquées"
chmod -R 755 storage/logs 2>/dev/null && print_success "Permissions récursives sur storage/logs/" || print_warning "Certaines permissions sur les logs n'ont pas pu être appliquées"
chmod -R 755 storage/framework 2>/dev/null && print_success "Permissions récursives sur storage/framework/" || print_warning "Certaines permissions sur framework n'ont pas pu être appliquées"

# Permissions sur bootstrap/cache
chmod -R 755 bootstrap/cache 2>/dev/null && print_success "Permissions sur bootstrap/cache/" || print_warning "Échec permissions bootstrap/cache/"

echo ""

# 3. Créer le lien symbolique
echo "🔗 Création du lien symbolique..."

# Supprimer l'ancien lien s'il existe
if [ -L "public/storage" ] || [ -d "public/storage" ]; then
    rm -rf public/storage 2>/dev/null
    print_info "Ancien lien supprimé"
fi

# Créer le nouveau lien
php artisan storage:link 2>/dev/null

if [ $? -eq 0 ]; then
    print_success "Lien symbolique créé avec succès"
elif [ -L "public/storage" ]; then
    print_success "Lien symbolique déjà existant et valide"
else
    print_warning "Tentative de création manuelle du lien..."
    # Chemin absolu du storage
    STORAGE_PATH=$(pwd)/storage/app/public
    ln -s "$STORAGE_PATH" public/storage 2>/dev/null
    
    if [ -L "public/storage" ]; then
        print_success "Lien symbolique créé manuellement"
    else
        print_error "Impossible de créer le lien symbolique"
        print_info "Créez-le manuellement : ln -s $(pwd)/storage/app/public public/storage"
    fi
fi

echo ""

# 4. Vérifications finales
echo "✅ Vérifications finales..."

# Vérifier que storage/app/public existe et est accessible en écriture
if [ -w "storage/app/public" ]; then
    print_success "storage/app/public est accessible en écriture"
else
    print_error "storage/app/public n'est PAS accessible en écriture"
fi

# Vérifier le lien symbolique
if [ -L "public/storage" ]; then
    TARGET=$(readlink public/storage)
    print_success "Lien symbolique public/storage → $TARGET"
else
    print_error "Le lien symbolique public/storage n'existe pas"
fi

# Tester l'écriture
TEST_FILE="storage/app/public/.test_write_$(date +%s)"
touch "$TEST_FILE" 2>/dev/null

if [ -f "$TEST_FILE" ]; then
    rm "$TEST_FILE"
    print_success "Test d'écriture réussi dans storage/app/public"
else
    print_error "Impossible d'écrire dans storage/app/public"
fi

echo ""

# 5. Optimisation Laravel (optionnel)
echo "🚀 Optimisation de l'application..."
php artisan config:cache 2>/dev/null && print_success "Config mise en cache" || print_warning "Échec du cache de config"
php artisan route:cache 2>/dev/null && print_success "Routes mises en cache" || print_warning "Échec du cache des routes"
php artisan view:cache 2>/dev/null && print_success "Views mises en cache" || print_warning "Échec du cache des vues"

echo ""

# 6. Affichage des permissions actuelles
echo "📊 Permissions actuelles des dossiers critiques:"
echo ""
ls -la storage/ | head -10
echo ""

# 7. Résumé
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║                      RÉSUMÉ                                    ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
print_info "Étapes suivantes recommandées:"
echo "  1. Testez un upload via votre application"
echo "  2. Consultez http://votre-domaine.com/diagnostic-storage.php"
echo "  3. Vérifiez les logs : tail -f storage/logs/laravel.log"
echo ""
print_warning "Si les problèmes persistent:"
echo "  • Vérifiez les restrictions open_basedir"
echo "  • Contactez le support Hostinger"
echo "  • Consultez le guide: GUIDE-RESOLUTION-UPLOAD-HOSTINGER.md"
echo ""

print_success "Script terminé !"
