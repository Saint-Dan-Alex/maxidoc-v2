<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Ajouter les contraintes de clé étrangère
            $table->foreign('category_id')
                  ->references('id')
                  ->on('courrier_categories')
                  ->nullOnDelete();

            $table->foreign('type')
                  ->references('id')
                  ->on('document_types')
                  ->nullOnDelete();

            $table->foreign('nature_id')
                  ->references('id')
                  ->on('courrier_natures')
                  ->nullOnDelete();

            $table->foreign('traitement_id')
                  ->references('id')
                  ->on('courrier_traitements')
                  ->nullOnDelete();

            $table->foreign('expediteur_externe')
                  ->references('id')
                  ->on('courrier_expediteurs')
                  ->nullOnDelete();

            $table->foreign('destinataire_externe_id')
                  ->references('id')
                  ->on('courrier_destinateur_externes')
                  ->nullOnDelete();

            $table->foreign('courrier_id')
                  ->references('id')
                  ->on('courriers')
                  ->nullOnDelete();

            $table->foreign('destination_id')
                  ->references('id')
                  ->on('destinations')
                  ->nullOnDelete();

            $table->foreign('redacteur_id')
                  ->references('id')
                  ->on('redacteurs')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['type']);
            $table->dropForeign(['nature_id']);
            $table->dropForeign(['traitement_id']);
            $table->dropForeign(['expediteur_externe']);
            $table->dropForeign(['destinataire_externe_id']);
            $table->dropForeign(['courrier_id']);
            $table->dropForeign(['destination_id']);
            $table->dropForeign(['redacteur_id']);
        });
    }
};
