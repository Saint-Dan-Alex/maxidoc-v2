#!/bin/bash
# Script pour consulter les logs de production via SSH

echo "================================================"
echo "   CONSULTATION LOGS PRODUCTION - MAXIDOC"
echo "================================================"
echo ""

# Connexion SSH et consultation des logs
ssh -p 65002 u115315654@82.25.113.217 << 'ENDSSH'
cd /home/u115315654/domains/maxidoc-lp.newtech-rdc.net

echo "=== DERNIERS LOGS (30 dernières lignes) ==="
tail -n 30 storage/logs/laravel.log

echo ""
echo "=== VERIFICATION ROUTE SCAN ==="
grep -n "courriers.scan\|courriers/scan" routes/web.php | head -5

echo ""
echo "=== VERIFICATION FICHIER BLADE ==="
grep -n "route('.*courriers.scan')" resources/views/livewire/courrier/add-courrier-form.blade.php

ENDSSH

echo ""
echo "================================================"
