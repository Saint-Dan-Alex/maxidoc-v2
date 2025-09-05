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
        Schema::table('documents', function (Blueprint $table) {
            // Ajouter les colonnes comme nullable d'abord
            $table->foreignId('redacteur_id')->nullable()->after('emetteur');
            $table->foreignId('destination_id')->nullable()->after('redacteur_id');
            
            // Ajouter les contraintes de clé étrangère
            $table->foreign('redacteur_id')
                  ->references('id')
                  ->on('redacteurs')
                  ->onDelete('set null');
                  
            $table->foreign('destination_id')
                  ->references('id')
                  ->on('destinations')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Supprimer les contraintes de clé étrangère d'abord
            $table->dropForeign(['redacteur_id']);
            $table->dropForeign(['destination_id']);
            
            // Puis supprimer les colonnes
            $table->dropColumn('redacteur_id');
            $table->dropColumn('destination_id');
        });
    }
};
