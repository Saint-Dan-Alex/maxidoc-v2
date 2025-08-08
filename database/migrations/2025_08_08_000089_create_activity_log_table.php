<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // Utilisateur à l'origine de l'action
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('causer_type')->nullable();
            
            // Modèle concerné par l'action
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            
            // Description de l'action
            $table->string('log_name')->nullable();
            $table->text('description');
            
            // Données supplémentaires
            $table->json('properties')->nullable();
            
            // Métadonnées de la requête
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 10)->nullable();
            
            // Référence à une session
            $table->string('session_id')->nullable();
            
            // Données de localisation
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('location')->nullable();
            
            // Données de l'appareil
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            
            // Données de performance
            $table->float('duration', 8, 3)->nullable()->comment('Durée en secondes');
            $table->integer('memory_usage')->nullable()->comment('Mémoire utilisée en octets');
            
            // Données de suivi
            $table->string('batch_uuid')->nullable();
            $table->string('event')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['subject_id', 'subject_type'], 'subject');
            $table->index(['causer_id', 'causer_type'], 'causer');
            $table->index('log_name');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};
