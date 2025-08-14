<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        // Lieux d'affectation à utiliser (correspondant à ta table)
        $lieux = [
            'Kinshasa-Limete',
            'Kinshasa-Maluku',
            'Matadi',
            // Ajoute d'autres lieux ici si besoin
        ];

        // On s'assure que les lieux existent en base
        foreach ($lieux as $titre) {
            if (!DB::table('lieu_affectations')->where('titre', $titre)->exists()) {
                DB::table('lieu_affectations')->insert([
                    'titre' => $titre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $agents = [
            [
                'nom' => 'JEHANO',
                'post_nom' => '',
                'prenom' => 'Erwan',
                'direction_titre' => 'Direction Générale',
                'fonction_titre' => 'Directeur Générale',
                'email' => 'erwanjehano@lerexcompetroleum.com',
                'matricule' => 'AGENT001',
                'sexe' => 'M',
                'lieu_titre' => 'Kinshasa-Limete',
            ],
            [
                'nom' => 'EKOSA',
                'post_nom' => '',
                'prenom' => 'Gaelle',
                'direction_titre' => 'Direction Générale',
                'fonction_titre' => 'Secretaire de Direction',
                'email' => 'gaelleekosa@lerexcompetroleum.com',
                'matricule' => 'AGENT002',
                'sexe' => 'F',
                'lieu_titre' => 'Kinshasa-Limete',
            ],
            [
                'nom' => 'MBALA',
                'post_nom' => '',
                'prenom' => 'Patrick',
                'direction_titre' => 'Direction Administratif',
                'fonction_titre' => 'Directeur Administratif',
                'email' => 'patrickmbala@lerexcompetroleum.com',
                'matricule' => 'AGENT003',
                'sexe' => 'M',
                'lieu_titre' => 'Kinshasa-Limete',
            ],
            [
                'nom' => 'MANTUMBU',
                'post_nom' => '',
                'prenom' => 'Christel',
                'direction_titre' => 'Direction Administratif',
                'fonction_titre' => 'Superviseur IT Matadi',
                'email' => 'christelmantumbu@lerexcompetroleum.com',
                'matricule' => 'AGENT004',
                'sexe' => 'M',
                'lieu_titre' => 'Matadi',
            ],
            [
                'nom' => 'TSHINGA',
                'post_nom' => '',
                'prenom' => 'Caleb',
                'direction_titre' => 'Direction Administratif',
                'fonction_titre' => 'Superviseur IT KINSHASA',
                'email' => 'calebtshinga@lerexcompetroleum.com',
                'matricule' => 'AGENT005',
                'sexe' => 'M',
                'lieu_titre' => 'Kinshasa-Limete', // ou Kinshasa-Maluku selon affectation réelle
            ],
            [
                'nom' => 'NTITI',
                'post_nom' => '',
                'prenom' => 'Cyrille',
                'direction_titre' => 'Direction Technique',
                'fonction_titre' => 'Directeur Technique',
                'email' => 'cyrillentiti@lerexcompetroleum.com',
                'matricule' => 'AGENT006',
                'sexe' => 'M',
                'lieu_titre' => 'Kinshasa-Limete',
            ],
            [
                'nom' => 'MBELE',
                'post_nom' => '',
                'prenom' => 'Serge',
                'direction_titre' => 'Direction Financier',
                'fonction_titre' => 'Manager Comptable',
                'email' => 'sergembele@lerexcompetroleum.com',
                'matricule' => 'AGENT007',
                'sexe' => 'M',
                'lieu_titre' => 'Kinshasa-Maluku',
            ],
            [
                'nom' => 'NSISI',
                'post_nom' => '',
                'prenom' => 'Alicia',
                'direction_titre' => 'Direction Commerciale',
                'fonction_titre' => 'Directrice Commerciale',
                'email' => 'aliciansisi@lerexcompetroleum.com',
                'matricule' => 'AGENT008',
                'sexe' => 'F',
                'lieu_titre' => 'Kinshasa-Limete',
            ],
        ];

        foreach ($agents as $data) {
            if (DB::table('agents')->where('matricule', $data['matricule'])->exists()) {
                continue;
            }

            $direction = DB::table('directions')->where('titre', $data['direction_titre'])->first();
            if (!$direction) {
                echo "Direction non trouvée : {$data['direction_titre']}\n";
                continue;
            }

            $fonction = DB::table('fonctions')->where('titre', $data['fonction_titre'])->first();
            if (!$fonction) {
                echo "Fonction non trouvée : {$data['fonction_titre']}\n";
                continue;
            }

            $lieu = DB::table('lieu_affectations')->where('titre', $data['lieu_titre'])->first();
            if (!$lieu) {
                echo "Lieu d'affectation non trouvé : {$data['lieu_titre']}\n";
                continue;
            }

            if (DB::table('users')->where('email', $data['email'])->exists()) {
                echo "Utilisateur déjà existant pour : {$data['email']}\n";
                continue;
            }

            $userId = DB::table('users')->insertGetId([
                'email' => $data['email'],
                'name' => Str::title("{$data['prenom']} {$data['nom']}"),
                'password' => Hash::make('12345678'),
                'statut_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('agents')->insert([
                'user_id' => $userId,
                'direction_id' => $direction->id,
                'fonction_id' => $fonction->id,
                'lieu_id' => $lieu->id,
                'statut_id' => 1,
                'nom' => Str::ucfirst(Str::lower($data['nom'])),
                'post_nom' => Str::ucfirst(Str::lower($data['post_nom'])),
                'prenom' => Str::ucfirst(Str::lower($data['prenom'])),
                'sexe' => $data['sexe'],
                'matricule' => $data['matricule'],
                'slug' => Str::slug("{$data['nom']} {$data['post_nom']} {$data['prenom']}"),
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
