<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Créer toutes les permissions
        $permissions = [
            'Gérer le personnel',
            'Voir les parametres',
            "Voir les lieux d'affectations",
            'Voir les Secretaires',
            'Voir les Assistants',
            'Voir les Fonctions',
            'Voir les Services',
            'Voir les Directions',
            'Voir les Grades',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Créer le rôle Super Admin
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        // 4. Donner toutes les permissions au rôle
        $role->syncPermissions($permissions);

        // 5. Attacher le rôle Super Admin à l’utilisateur id=1
        $user = User::find(1);
        if ($user) {
            $user->syncRoles(['Super Admin']);
        }
    }
}
