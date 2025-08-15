<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Vérifie si l'admin existe déjà
        $admin = DB::table('users')->where('email', 'admin@maxidoc.com')->first();

        if (!$admin) {
            // Créer l'utilisateur admin
            $adminId = DB::table('users')->insertGetId([
                'name' => 'Admin system',
                'email' => 'admin@maxidoc.com',
                'password' => Hash::make('password'),
                'statut_id' => 1,
                'role_id' => 1,
                'email_verified_at' => now(),
                'first_use' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $adminId = $admin->id;
        }

        // Vérifie si l'agent existe déjà
        $agentExists = DB::table('agents')->where('user_id', $adminId)->exists();

        if (!$agentExists) {
            // Créer l'agent lié à l'utilisateur admin
            DB::table('agents')->insert([
                'user_id' => $adminId,
                'statut_id' => 1,
                'nom' => 'Admin system',
                'matricule' => 'ADM-0001',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
