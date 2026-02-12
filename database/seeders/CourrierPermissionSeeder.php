<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CourrierPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nettoyer le cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Définir les nouvelles permissions
        $permissions = [
            'Supprimer un courrier',
            'Restaurer un courrier',
            'Suppression définitive',
        ];

        // 2. Créer les permissions si elles n'existent pas
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['module_id' => 2] // Module Courrier
            );
        }

        // 3. Assigner au rôle Super Admin (s'il existe)
        $role = Role::where('name', 'Super Admin')->first();
        if ($role) {
            foreach ($permissions as $permission) {
                if (!$role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
