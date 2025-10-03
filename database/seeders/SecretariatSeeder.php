<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecretariatSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si la direction avec l'ID 1 existe
        $direction = DB::table('directions')->first();
        
        if ($direction) {
            DB::table('secretariats')->insert([
                [
                    'titre' => 'Service Accueil',
                    'direction_id' => $direction->id,
                    'responsable_id' => null,
                    'for_dg' => true,
                    'for_dga' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
