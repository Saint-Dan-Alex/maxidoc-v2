<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Créer ou récupérer l'admin
        $admin = DB::table('users')->where('email', 'calebtshinga@gmail.com')->first();

        if (!$admin) {
            $adminId = DB::table('users')->insertGetId([
                'name' => 'Admin system',
                'email' => 'calebtshinga@gmail.com',
                'password' => Hash::make('password'),
                'statut_id' => 1,
                'email_verified_at' => now(),
                'first_use' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $adminId = $admin->id;
        }

        // 2. Créer ou récupérer l'agent lié
        $agentExists = DB::table('agents')->where('user_id', $adminId)->exists();
        if (!$agentExists) {
            DB::table('agents')->insert([
                'user_id' => $adminId,
                'statut_id' => 1,
                'nom' => 'Admin system',
                'matricule' => 'ADM-0001',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Créer les permissions spécifiques Super Admin
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

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 4. Créer le rôle Super Admin et lui assigner les permissions
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $role->syncPermissions($permissions);

        // 5. Attacher le rôle Super Admin à l'utilisateur
        $user = User::find($adminId);
        if ($user && !$user->hasRole('Super Admin')) {
            $user->syncRoles(['Super Admin']);
        }

        // 6. Nettoyer le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
