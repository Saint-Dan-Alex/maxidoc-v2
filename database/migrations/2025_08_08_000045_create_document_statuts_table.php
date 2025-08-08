<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour insérer les données

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertion des statuts par défaut
        DB::table('document_statuts')->insert([
            ['titre' => 'En attente de traitement', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'En cours de traitement', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Bloqué', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Réjéter', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Traité', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Archivé', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('document_statuts');
    }
};
