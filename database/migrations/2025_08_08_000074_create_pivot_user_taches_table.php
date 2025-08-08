<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_user_taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            
            // Type de relation (créateur, responsable, participant, observateur, etc.)
            $table->string('role', 50)->default('participant');
            
            // Préférences de notification
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_sms')->default(false);
            $table->boolean('notify_in_app')->default(true);
            
            // Statut de la tâche pour cet utilisateur
            $table->enum('statut_personnel', ['en_attente', 'en_cours', 'termine', 'en_retard'])->default('en_attente');
            $table->dateTime('date_debut_perso')->nullable();
            $table->dateTime('date_fin_perso')->nullable();
            
            // Suivi personnel
            $table->integer('temps_passe_perso')->default(0); // en minutes
            $table->text('notes_personnelles')->nullable();
            
            // Métadonnées
            $table->boolean('est_favori')->default(false);
            $table->json('preferences')->nullable(); // Pour stocker des préférences supplémentaires
            
            $table->timestamps();
            
            // Contrainte d'unicité
            $table->unique(['user_id', 'tache_id', 'role']);
            
            // Index
            $table->index(['user_id', 'statut_personnel']);
            $table->index(['tache_id', 'role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_user_taches');
    }
};
