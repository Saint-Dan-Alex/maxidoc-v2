<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_taches_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            
            // Rôle dans la tâche (responsable, participant, observateur, etc.)
            $table->string('role', 50)->default('participant');
            
            // Informations de participation
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'en_retard'])->default('en_attente');
            $table->integer('charge_travail')->nullable(); // en pourcentage ou heures
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            
            // Évaluation et feedback
            $table->integer('evaluation')->nullable(); // Note sur 10
            $table->text('feedback')->nullable();
            
            // Suivi du temps
            $table->integer('temps_estime')->nullable(); // en minutes
            $table->integer('temps_passe')->default(0); // en minutes
            
            // Métadonnées
            $table->boolean('est_actif')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index
            $table->unique(['tache_id', 'agent_id', 'role']);
            $table->index(['agent_id', 'statut']);
            $table->index(['tache_id', 'statut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_taches_agents');
    }
};
