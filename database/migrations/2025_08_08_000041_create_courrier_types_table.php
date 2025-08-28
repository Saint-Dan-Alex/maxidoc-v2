<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour utiliser DB::table()

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_types', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 20)->nullable();
            $table->timestamps();
        });

        // Insertion des types de courrier par défaut
        DB::table('courrier_types')->insert([
            ['titre' => 'Entrant', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Sortant', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Interne', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types');
    }
};
