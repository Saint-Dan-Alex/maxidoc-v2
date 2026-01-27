<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte erronée (pointait vers courrier_traitements)
            $table->dropForeign(['traitement_id']);
        });

        Schema::table('courriers', function (Blueprint $table) {
            // Ajouter la nouvelle contrainte vers la bonne table
            $table->foreign('traitement_id')
                  ->references('id')
                  ->on('courrier_types_traitements')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Supprimer la contrainte corrigée
            $table->dropForeign(['traitement_id']);
        });

        Schema::table('courriers', function (Blueprint $table) {
            // Rétablir l'ancienne contrainte (vers courrier_traitements)
            $table->foreign('traitement_id')
                  ->references('id')
                  ->on('courrier_traitements')
                  ->nullOnDelete();
        });
    }
};
