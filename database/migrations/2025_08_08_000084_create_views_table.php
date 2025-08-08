<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            
            // Modèle visualisé
            $table->string('viewable_type');
            $table->unsignedBigInteger('viewable_id');
            
            // Utilisateur qui a visualisé
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Données de session pour les utilisateurs non connectés
            $table->string('session_id')->nullable();
            
            // Métadonnées
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            
            // Durée de la visualisation (en secondes)
            $table->integer('duree')->default(0);
            
            // Données techniques
            $table->string('device_type', 20)->nullable(); // desktop, mobile, tablet
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['viewable_type', 'viewable_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('session_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('views');
    }
};
