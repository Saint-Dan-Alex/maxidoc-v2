<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Type de notification (peut être utilisé pour le routage)
            $table->string('type');
            
            // Données de la notification (sérialisées en JSON)
            $table->json('data');
            
            // Date de lecture de la notification
            $table->timestamp('read_at')->nullable();
            
            // Référence à l'utilisateur destinataire
            $table->foreignId('notifiable_id')->constrained('users')->cascadeOnDelete();
            $table->string('notifiable_type'); // Pour la polymorphie si nécessaire
            
            // Métadonnées
            $table->string('titre');
            $table->text('message');
            $table->string('lien')->nullable();
            $table->string('icone', 50)->nullable();
            $table->string('couleur', 20)->nullable();
            
            // Niveau de priorité (info, warning, error, success)
            $table->enum('niveau', ['info', 'warning', 'error', 'success'])->default('info');
            
            // Expiration de la notification
            $table->timestamp('expire_at')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['notifiable_id', 'notifiable_type', 'read_at']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
