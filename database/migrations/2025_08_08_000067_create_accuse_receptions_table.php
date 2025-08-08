<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('accuse_receptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('agents');
            
            // Type d'accusé (lecture, réception, prise en charge, etc.)
            $table->string('type', 50);
            
            // Statut de l'accusé (envoyé, reçu, lu, etc.)
            $table->enum('statut', ['envoye', 'recu', 'lu', 'erreur'])->default('envoye');
            
            // Date et heure de l'action
            $table->dateTime('date_envoi')->nullable();
            $table->dateTime('date_reception')->nullable();
            $table->dateTime('date_lecture')->nullable();
            
            // Informations techniques
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('signature', 255)->nullable();
            
            // Commentaires
            $table->text('commentaire')->nullable();
            
            // Référence à un traitement spécifique si applicable
            $table->foreignId('traitement_id')->nullable()->constrained('courrier_traitements')->nullOnDelete();
            
            $table->timestamps();
            
            // Index
            $table->index(['courrier_id', 'agent_id', 'type']);
            $table->index(['statut', 'date_envoi']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('accuse_receptions');
    }
};
