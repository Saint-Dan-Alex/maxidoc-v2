<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            
            // Statut et priorité
            $table->foreignId('statut_id')->constrained('taches_statuts');
            $table->enum('priorite', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            
            // Dates importantes
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_echeance')->nullable();
            $table->dateTime('date_fin')->nullable();
            
            // Progression
            $table->integer('progression')->default(0); // 0-100
            
            // Confidentialité
            $table->boolean('est_privee')->default(false);
            
            // Références
            $table->foreignId('courrier_id')->nullable()->constrained('courriers')->nullOnDelete();
            $table->foreignId('document_id')->nullable()->constrained('documents')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('taches')->nullOnDelete();
            
            // Création et mise à jour
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            
            // Suivi
            $table->integer('temps_estime')->nullable(); // en minutes
            $table->integer('temps_passe')->default(0); // en minutes
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['statut_id', 'date_echeance', 'priorite']);
            $table->index(['created_by', 'est_privee']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches');
    }
};
