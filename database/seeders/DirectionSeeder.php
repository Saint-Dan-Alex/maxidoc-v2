<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DirectionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Liste des directions et départements
        $entries = [
            ['titre' => 'Direction Administrative', 'code' => 'DA', 'description' => 'Direction'],
            ['titre' => 'Direction Commerciale', 'code' => 'DC', 'description' => 'Direction'],
            ['titre' => 'Direction Financière', 'code' => 'DF', 'description' => 'Direction'],
            ['titre' => 'Direction Technique', 'code' => 'DT', 'description' => 'Direction'],
            ['titre' => 'Direction des Opérations', 'code' => 'DO', 'description' => 'Direction'],
        ];

        $divisionData = [];

        // Direction Générale initiale
        $dgId = DB::table('directions')->insertGetId([
            'titre' => 'Direction Générale',
            'code' => 'DG',
            'description' => 'Direction Générale',
            'lieu_id' => 1,
            'responsable_id' => null,
            'slug' => 'direction-generale',
            'adjoint_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $divisionData[] = [
            'libelle' => 'Direction Générale',
            'description' => 'Direction Générale',
            'direction_id' => $dgId,
            'responsable_id' => null,
            'statut_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Insertion unique des directions pour Kinshasa (Lieu ID 1)
        $lieuId = 1;

        foreach ($entries as $entry) {
            $directionId = DB::table('directions')->insertGetId([
                'titre' => $entry['titre'],
                'code' => $entry['code'],
                'description' => $entry['description'],
                'lieu_id' => $lieuId,
                'responsable_id' => null,
                'slug' => Str::slug($entry['titre']),
                'adjoint_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $divisionData[] = [
                'libelle' => $entry['titre'],
                'description' => $entry['description'],
                'direction_id' => $directionId,
                'responsable_id' => null,
                'statut_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insérer les divisions
        DB::table('divisions')->insert($divisionData);
    }
}
