<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->primary(['permission_id', 'model_id', 'model_type']);
            $table->index(['model_id', 'model_type']);
        });

    //     // Exemple d'insertion: donner toutes les permissions à l'utilisateur id 1
    //     $permissions = DB::table('permissions')->pluck('id');

    //     $data = [];
    //     foreach ($permissions as $permissionId) {
    //         $data[] = [
    //             'permission_id' => $permissionId,
    //             'model_type' => 'App\Models\User', // ou ton namespace User
    //             'model_id' => 1,
    //         ];
    //     }

    //     DB::table('model_has_permissions')->insert($data);

    // 2. Récupération de toutes les permissions
    $permissions = DB::table('permissions')->get()->keyBy('name');

    // 3. Attribution des permissions selon le rôle → utilisateur (model_id)
    $rolePermissions = [
        'Super Admin' => [ 
            'Gérer le personnel',
            'Voir les parametres','Voir les lieux d\'affectations','Voir les Secretaires',
            'Voir les Assistants','Voir les Fonctions','Voir les Services','Voir les Directions'
        ],
        'Directeur Générale' => collect($permissions)->keys()->filter(fn($name) => $name !== 'Voir les parametres')->toArray(),
        'Responsable de Direction' => collect($permissions)->keys()->filter(fn($name) => !in_array($name, [
            'Voir les parametres',
            'Gérer le personnel',
            'Archiver',
        ]))->toArray(),
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
        'Agents' => [
            'Voir le tableau de bord',
            'Voir les documents',
            'Voir les taches',
            'Numériser un document',
            'Voir les courriers',
        ],
    ];

    // 4. Lien entre utilisateurs et rôles
    $userRoles = [
        1 => 'Super Admin',
        2 => 'Directeur Générale',
        3 => 'Responsable de Direction',
        4 => 'Assistant',
        5 => 'Secrétaire',
        6 => 'Archiviste',
        7 => 'Service Accueil',
        8 => 'Agents',
    ];

    $insertData = [];

    foreach ($userRoles as $userId => $roleName) {
        $permissionNames = $rolePermissions[$roleName] ?? [];

        foreach ($permissionNames as $permName) {
            $permission = $permissions[$permName] ?? null;

            if ($permission) {
                $insertData[] = [
                    'permission_id' => $permission->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $userId,
                ];
            }
        }
    }

    // 5. Insertion dans model_has_permissions
    DB::table('model_has_permissions')->insert($insertData);
}
    

    public function down()
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
