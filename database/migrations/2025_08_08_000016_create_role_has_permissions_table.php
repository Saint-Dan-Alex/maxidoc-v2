<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade');
                  
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // Récupération des permissions et rôles
        $permissions = DB::table('permissions')->get()->keyBy('name');
        $roles = DB::table('roles')->get()->keyBy('name');

        // VOTRE STRUCTURE EXACTE DE PERMISSIONS PAR RÔLE
        $rolePermissions = [
            'Super Admin' => [
                'Gérer le personnel',
                'Voir les parametres',
                "Voir les lieux d'affectations",
                'Voir les Secretaires',
                'Voir les Assistants',
                'Voir les Fonctions',
                'Voir les Services',
                'Voir les Directions',
                'Voir les Grades',
            ],

            'Directeur Générale' => DB::table('permissions')
                ->whereNotIn('name', [
                    'Voir les parametres',
                    'Gérer le personnel',
                    'Archiver'
                ])
                ->pluck('name')
                ->toArray(),

            'Responsable de Direction' => DB::table('permissions')
                ->whereNotIn('name', [
                    'Voir les parametres',
                    'Gérer le personnel',
                    'Archiver'
                ])
                ->pluck('name')
                ->toArray(),

            'Assistant' => [
                'Voir le tableau de bord',
                'Voir les documents',
                'Voir les taches',
                'Numériser un document',
                'Voir les courriers',
            ],

            'Secrétaire' => [
                'Voir le tableau de bord',
                'Voir les documents',
                'Voir les taches',
                'Numériser un document',
                'Voir les courriers',
            ],

            'Archiviste' => [
                'Voir les documents',
                'Archiver',
            ],

            'Service Accueil' => [
                'Numériser un document entrant',
                'Voir les courriers',
            ],

            'Agent' => [
                'Voir le tableau de bord',
                'Voir les documents',
                'Voir les taches',
                'Numériser un document',
                'Voir les courriers',
            ],
        ];

        // Attribution des permissions
        $insertData = [];
        
        foreach ($rolePermissions as $roleName => $permissionNames) {
            if (!isset($roles[$roleName])) {
                continue; // Si le rôle n'existe pas, on passe au suivant
            }

            foreach ($permissionNames as $permName) {
                if (isset($permissions[$permName])) {
                    $insertData[] = [
                        'role_id' => $roles[$roleName]->id,
                        'permission_id' => $permissions[$permName]->id,
                    ];
                }
            }
        }

        // Insertion en une seule requête
        if (!empty($insertData)) {
            DB::table('role_has_permissions')->insert($insertData);
        }
    }

    public function down()
    {
        Schema::dropIfExists('role_has_permissions');
    }
};