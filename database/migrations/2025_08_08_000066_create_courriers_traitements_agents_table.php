<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_traitements_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_traitement_id')->constrained('courrier_traitements')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            
            // Rôle de l'agent dans ce traitement (responsable, participant, etc.)
            $table->string('role', 50);
            
            // Statut de participation
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'abandonne'])->default('en_attente');
            
            // Période d'intervention
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            
            // Commentaires et évaluation
            $table->text('commentaire')->nullable();
            $table->integer('efficacite')->nullable(); // Note de 1 à 5
            
            // Signature électronique
            $table->string('signature_hash', 255)->nullable();
            $table->dateTime('date_signature')->nullable();
            
            $table->timestamps();
            
            // Contrainte d'unicité
            $table->unique(['courrier_traitement_id', 'agent_id', 'role']);
            
            // Index
            $table->index(['agent_id', 'statut']);
            $table->index(['courrier_traitement_id', 'statut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_traitements_agents');
    }
};
