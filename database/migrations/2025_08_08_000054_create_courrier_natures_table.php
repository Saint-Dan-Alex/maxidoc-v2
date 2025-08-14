<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_natures', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100)->nullable();
            $table->longText('modele')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertion des natures de courrier
        DB::table('courrier_natures')->insert([
            ['titre' => 'Lettre ordinaire', 'modele' => 'template-1', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Lettre administrative', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Lettre amicale', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Lettre officielle', 'modele' => 'template-2', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Lettre commerciale', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Lettre professionnelle', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Contrat', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Demande de service', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Offre de service', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Facture', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Correspondance', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'CV 2', 'modele' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_natures');
    }
};
