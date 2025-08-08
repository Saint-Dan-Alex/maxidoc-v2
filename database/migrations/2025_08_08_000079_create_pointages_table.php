<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            
            // Type de pointage (entrée, sortie, pause, etc.)
            $table->enum('type', ['entree', 'sortie', 'debut_pause', 'fin_pause', 'deplacement']);
            
            // Date et heure du pointage
            $table->dateTime('date_heure');
            
            // Localisation (si disponible)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('adresse')->nullable();
            
            // Méthode de pointage (badge, mobile, web, etc.)
            $table->string('methode', 50)->default('web');
            
            // Statut (validé, en attente, rejeté)
            $table->enum('statut', ['valide', 'en_attente', 'rejete'])->default('valide');
            
            // Commentaires
            $table->text('commentaire')->nullable();
            
            // Référence à un éventuel modérateur
            $table->foreignId('modere_par')->nullable()->constrained('users');
            $table->text('raison_moderation')->nullable();
            
            // Données techniques
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('appareil_id', 100)->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['agent_id', 'date_heure']);
            $table->index(['type', 'statut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pointages');
    }
};
