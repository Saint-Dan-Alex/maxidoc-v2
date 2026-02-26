# Plan de Modification du Schéma - Protocole B.L.A.S.T.

## Introduction
Ce document détaille les modifications de structure nécessaires pour l'implémentation de la délégation d'autorité contextuelle dans MaxiDoc.

## Modifications Proposées

### 1. Table `delegations`
Cette table gère le cycle de vie de la délégation.
- `id`: Clé primaire
- `delegator_id`: (FK) Utilisateur qui délègue (Type: DG)
- `delegate_id`: (FK) Utilisateur qui reçoit l'accès
- `start_date`: Début de validité
- `end_date`: Fin de validité
- `is_active`: Kill-switch manuel
- `created_at/updated_at`: Timestamps standards

### 2. Table `user_actions` (Audit)
Extension pour la traçabilité "Pour Ordre".
- `represented_user_id`: (FK) ID du DG si l'action est déléguée.
- `delegation_token`: Identifiant unique de la session de délégation utilisée.

## Contraintes de Sécurité
- Un index composite sera créé sur `delegate_id + is_active + dates` pour garantir que le middleware de vérification ne dégrade pas les performances (O(1) ou O(log n)).
- La révocation est atomique via le champ `is_active`.

## Approbation Requise
Veuillez répondre par **"GO"** pour générer les fichiers de migration Laravel.
