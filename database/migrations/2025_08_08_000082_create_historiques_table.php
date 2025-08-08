<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            
            // Utilisateur qui a effectué l'action
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Type d'action (création, modification, suppression, etc.)
            $table->string('action', 50);
            
            // Modèle concerné (sous forme de chaîne complète)
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            
            // Données avant/après (sérialisées en JSON)
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            
            // URL de la requête
            $table->string('url')->nullable();
            
            // Adresse IP et user agent
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            // Tags pour faciliter les recherches
            $table->json('tags')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['model_type', 'model_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historiques');
    }
};
