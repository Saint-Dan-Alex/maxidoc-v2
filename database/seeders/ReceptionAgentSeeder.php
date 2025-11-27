<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ReceptionAgentSeeder extends Seeder
{
    public function run(): void
    {
        // 0. S'assurer que les lieux d'affectation existent (comme dans AgentSeeder)
        $lieux = [
            'Kinshasa-Limete',
            'Kinshasa-Maluku',
            'Matadi',
        ];

        foreach ($lieux as $titre) {
            if (!DB::table('lieu_affectations')->where('titre', $titre)->exists()) {
                DB::table('lieu_affectations')->insert([
                    'titre' => $titre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 1. Créer ou récupérer l'utilisateur de réception
        $user = DB::table('users')->where('email', 'reception@maxidoc.com')->first();

        if (!$user) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Agent Reception',
                'email' => 'reception@maxidoc.com',
                'password' => Hash::make('12345678'),
                'statut_id' => 1,
                'email_verified_at' => now(),
                'first_use' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $userId = $user->id;
        }

        // 2. Résoudre direction/fonction/lieu comme dans AgentSeeder
        $directionTitre = 'Direction Générale';
        $fonctionTitre = 'Support Administratif';
        $lieuTitre = 'Kinshasa-Limete';

        $direction = DB::table('directions')->where('titre', $directionTitre)->first();
        $fonction = DB::table('fonctions')->where('titre', $fonctionTitre)->first();
        $lieu = DB::table('lieu_affectations')->where('titre', $lieuTitre)->first();

        // 3. Créer l'agent lié avec les champs complets si absent
        $agentExists = DB::table('agents')->where('user_id', $userId)->exists();
        if (!$agentExists) {
            $nom = ucfirst(strtolower('Reception'));
            $postNom = ucfirst(strtolower(''));
            $prenom = ucfirst(strtolower('Agent'));

            DB::table('agents')->insert([
                'user_id' => $userId,
                'direction_id' => $direction?->id,
                'fonction_id' => $fonction?->id,
                'lieu_id' => $lieu?->id,
                'statut_id' => 1,
                'nom' => $nom,
                'post_nom' => $postNom,
                'prenom' => $prenom,
                'sexe' => 'M',
                'matricule' => 'REC-0001',
                'slug' => Str::slug("$nom $postNom $prenom"),
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Créer le rôle "Reception" (si Spatie/Permission est installé) et l'assigner
        try {
            $role = Role::firstOrCreate(['name' => 'Reception']);
            $u = User::find($userId);
            if ($u && !$u->hasRole('Reception')) {
                $u->syncRoles(['Reception']);
            }
        } catch (\Throwable $e) {
            // Si Spatie n'est pas installé ou table roles absente, ignorer silencieusement.
        }
    }
}
