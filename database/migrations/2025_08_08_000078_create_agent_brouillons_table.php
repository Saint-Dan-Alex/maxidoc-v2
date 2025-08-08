<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agent_brouillons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('brouillon_id')->constrained('brouillons')->cascadeOnDelete();
            
            // Type d'accès (propriétaire, collaborateur, lecteur, etc.)
            $table->string('type_acces', 50)->default('proprietaire');
            
            // Détails des permissions
            $table->boolean('peut_modifier')->default(false);
            $table->boolean('peut_partager')->default(false);
            $table->boolean('peut_supprimer')->default(false);
            
            // Dates d'accès
            $table->dateTime('date_debut_acces')->useCurrent();
            $table->dateTime('date_fin_acces')->nullable();
            
            // Suivi
            $table->foreignId('ajoute_par')->constrained('users');
            $table->text('raison_partage')->nullable();
            
            $table->timestamps();
            
            // Contrainte d'unicité
            $table->unique(['agent_id', 'brouillon_id']);
            
            // Index
            $table->index(['brouillon_id', 'type_acces']);
            $table->index(['agent_id', 'date_debut_acces']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('agent_brouillons');
    }
};
