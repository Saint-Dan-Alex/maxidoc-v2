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
            ['titre' => 'Administration Générale', 'parent' => 'Direction Administrative'],

            ['titre' => 'Caisse', 'parent' => 'Direction Financière'],
            ['titre' => 'Commercial', 'parent' => 'Direction Commerciale'],
            ['titre' => 'Comptabilité', 'parent' => 'Direction Financière'],
            ['titre' => 'Direction Générale', 'parent' => 'Direction Générale'],
            ['titre' => 'Departement Appro', 'parent' => 'Direction Générale'],
            ['titre' => 'Departement Business Analyse', 'parent' => 'Direction Générale'],
            ['titre' => 'Departement HSSEQ (PFSO)', 'parent' => 'Direction Générale'],
            ['titre' => 'Dispatching', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Douane et Transit', 'parent' => 'Direction Financière'],
            ['titre' => 'Facturation', 'parent' => 'Direction Financière'],
            ['titre' => 'Finance', 'parent' => 'Direction Financière'],
            ['titre' => 'Gestion des Stocks', 'parent' => 'Direction Commerciale'],
            ['titre' => 'Génie Civil', 'parent' => 'Direction Technique'],

            ['titre' => 'Informatique', 'parent' => 'Direction Administrative'],
            ['titre' => 'Intendance', 'parent' => 'Direction Administrative'],
            ['titre' => 'Laboratoire', 'parent' => 'Direction Technique'],
            ['titre' => 'Magasinage', 'parent' => 'Direction Administrative'],
            ['titre' => 'Mécanique', 'parent' => 'Direction Technique'],
            ['titre' => 'Métrologie', 'parent' => 'Direction Technique'],
            ['titre' => 'Opérations', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Paie et Carrière', 'parent' => 'Direction Administrative'],
            ['titre' => 'Planification', 'parent' => 'Direction Technique'],
            ['titre' => 'Ressources Humaines', 'parent' => 'Direction Administrative'],
            ['titre' => 'Services Généraux', 'parent' => 'Direction Administrative'],
            ['titre' => 'Stations', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Stations-Service', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Technique', 'parent' => 'Direction Technique'],
            ['titre' => 'Terminal', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Transport', 'parent' => 'Direction des Opérations'],
            ['titre' => 'Trésorerie', 'parent' => 'Direction Financière'],
            ['titre' => 'Électricité', 'parent' => 'Direction Technique'],
            ['titre' => 'Équipes Opérationnelles', 'parent' => 'Direction des Opérations'],
        ];

        $data = [];

        // Insertion unique des services (liés aux directions uniques)
        foreach ($services as $service) {
            // Cherche la direction associée au parent
            $direction = DB::table('directions')
                ->where('titre', $service['parent'])
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
