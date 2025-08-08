<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            
            // Modèle concerné
            $table->string('revisionable_type');
            $table->unsignedBigInteger('revisionable_id');
            
            // Utilisateur ayant effectué la modification
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Données de la révision
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            
            // Type de modification (create, update, delete, restore, etc.)
            $table->string('key');
            
            // Numéro de version (incrémentiel)
            $table->unsignedInteger('revision_number')->default(0);
            
            // Métadonnées
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['revisionable_type', 'revisionable_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('key');
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisions');
    }
};
