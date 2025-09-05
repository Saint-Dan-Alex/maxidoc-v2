<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Liste des services avec le parent (direction ou département)
        $services = [
            ['titre' => 'Administration Générale', 'parent' => 'Direction Administratif'],
            ['titre' => 'Appro', 'parent' => 'Departement Appro'],
            ['titre' => 'Business Analyse', 'parent' => 'Departement Business Analyse'],
            ['titre' => 'Caisse', 'parent' => 'Direction Financier'],
            ['titre' => 'Commercial', 'parent' => 'Direction Commerciale'],
            ['titre' => 'Comptabilité', 'parent' => 'Direction Financier'],
            ['titre' => 'Direction Générale', 'parent' => 'Direction Générale'],
            ['titre' => 'Dispatching', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Douane et Transit', 'parent' => 'Direction Financier'],
            ['titre' => 'Facturation', 'parent' => 'Direction Financier'],
            ['titre' => 'Finance', 'parent' => 'Direction Financier'],
            ['titre' => 'Gestion des Stocks', 'parent' => 'Direction Commerciale'],
            ['titre' => 'Génie Civil', 'parent' => 'Direction Technique'],
            ['titre' => 'HSSEQ (PFSO)', 'parent' => 'Departement HSSEQ (PFSO)'],
            ['titre' => 'Informatique', 'parent' => 'Direction Administratif'],
            ['titre' => 'Intendance', 'parent' => 'Direction Administratif'],
            ['titre' => 'Laboratoire', 'parent' => 'Direction Technique'],
            ['titre' => 'Magasinage', 'parent' => 'Direction Administratif'],
            ['titre' => 'Mécanique', 'parent' => 'Direction Technique'],
            ['titre' => 'Métrologie', 'parent' => 'Direction Technique'],
            ['titre' => 'Opérations', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Paie et Carrière', 'parent' => 'Direction Administratif'],
            ['titre' => 'Planification', 'parent' => 'Direction Technique'],
            ['titre' => 'Ressources Humaines', 'parent' => 'Direction Administratif'],
            ['titre' => 'Services Généraux', 'parent' => 'Direction Administratif'],
            ['titre' => 'Stations', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Stations-Service', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Technique', 'parent' => 'Direction Technique'],
            ['titre' => 'Terminal', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Transport', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Trésorerie', 'parent' => 'Direction Financier'],
            ['titre' => 'Électricité', 'parent' => 'Direction Technique'],
            ['titre' => 'Équipes Opérationnelles', 'parent' => 'Direction des Opérations'],
        ];

        $data = [];

        // Pour chaque lieu_id 1 à 3
        foreach (range(1, 3) as $lieuId) {
            foreach ($services as $service) {
                // Cherche la direction associée au parent pour ce lieu
                $direction = DB::table('directions')
                    ->where('titre', $service['parent'])
                    ->where('lieu_id', $lieuId)
                    ->first();

                if ($direction) {
                    $data[] = [
                        'direction_id' => $direction->id,
                        'division_id' => null,
                        'responsable_id' => null,
                        'titre' => $service['titre'],
                        'description' => $service['titre'],
                        'statut_id' => 1,
                        'parent_id' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        if (!empty($data)) {
            // Insertion des services
            DB::table('services')->insert($data);
        }

        // Ensuite on insère les sections liées
        foreach ($data as $serviceData) {
            // Récupérer l'ID du service inséré
            $service = DB::table('services')
                ->where('titre', $serviceData['titre'])
                ->where('direction_id', $serviceData['direction_id'])
                ->where('created_at', $serviceData['created_at'])
                ->first();

            if ($service) {
                DB::table('sections')->insert([
                    'titre' => $serviceData['titre'],
                    'description' => $serviceData['description'],
                    'division_id' => $serviceData['direction_id'], // même logique que store()
                    'responsable_id' => $serviceData['responsable_id'],
                    'statut_id' => $serviceData['statut_id'],
                    'service_id' => $service->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
