<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FonctionSeeder extends Seeder
{
    public function run(): void
    {
        $fonctions = [
            'Superviseur Commerciale',
            'Superviseur Dispatsheur',
            'Superviseur Gest. Stocks',
            'Superviseur HSSEQ (PFSO) Kinshasa',
            'Superviseur HSSEQ (PFSO) Matadi',
            'Superviseur IT KINSHASA',
            'Superviseur IT Matadi',
            'Superviseur Laboratoire',
            'Superviseur Technique',
            'Superviseur de Convois',
            'Superviseur des Opérations',
            'Manager Appro',
            'Manager Business Analyste',
            'Manager Com. & Gest Stock',
            'Manager Comptable',
            'Manager HSSEQ (PFSO)',
            'Manager Technique',
            'Manager Terminal/PFSO Kinshasa',
            'Manager Terminal/PFSO Matadi',
            'Manager des ressources humaines',
            'Ass Appro Kinshasa',
            'Ass. Administratif',
            'Ass. Chef Comptable',
            'Ass. Dispatche Kinshasa',
            'Ass. Magasinier Maluku',
            'Ass. Team Leader Kinshasa',
            'Opérateur Polyvalent',
            'Agent Commerciale',
            'Agent Station Rélais Kimpese',
            'Agent Transit Matadi',
            'Caissière Maluku',
            'Caissière Matadi',
            'Caissière Principale',
            'Controleur perte & Coulage Kinshasa',
            'Controleur perte & Coulage Matadi',
            'IT Support Kinshasa-Limete',
            'IT Support Kinshasa-Maluku',
            'IT Support Matadi',
            'Technicien Lab. Kinshasa 1',
            'Technicien Lab. Matadi 1',
            'Technicien Lab. Matadi 2',
            'Directeur Technique',
            'Dispatcheur Kinshasa',
            'Dispatcheur Matadi',
            'Douane & Transit',
            'Electricien',
            'Magasinier Maluku',
            'Magasinier Matadi',
            'Metrologue',
            'Safety Officer Kinshasa',
            'Safety Officer Matadi',
            'Team Leader Kinshasa',
            'Team Leader Matadi',
            'Chargé des projets & Controleur interne',
            'Chef Mécanicien',
            'Chef Garage',
            'Comptabilité Analytique',
            'Comptabilité Générale',
            'Directeur Administratif',
            'Directrice Commerciale',
            'Directeur Générale',
            'Directeur des Opérations',
            'Facturation & Récouvrement',
            'Gestionnaire des stocks',
            'Génie Civile',
            'Planificateur Technique',
            'Pompiste & Jauguer',
            'Resp. Adm & Sce Généraux',
            'Resp. Camère & Paie',
            'Sapeur Pompier',
            'Secretaire de Direction',
            'Service Intendant Maluku',
            'Support Administratif',
            'Trésorière Principale'
        ];

        $now = now();

        foreach ($fonctions as $fonction) {
            DB::table('fonctions')->insert([
                'titre' => $fonction,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
