<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssistanatSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si la direction avec l'ID 1 existe
        $direction = DB::table('directions')->where('code', 'DG')->first();
        
        if ($direction) {
            DB::table('assistanats')->insert([
                [
                    'titre' => 'Assistant du DG',
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
