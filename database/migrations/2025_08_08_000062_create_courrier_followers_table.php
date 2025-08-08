<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Type de suivi (pour les notifications)
            $table->enum('type', ['suivi', 'notification', 'information'])->default('suivi');
            
            // Préférences de notification
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_sms')->default(false);
            $table->boolean('notify_in_app')->default(true);
            
            // Métadonnées
            $table->dateTime('date_derniere_notification')->nullable();
            $table->text('preferences')->nullable(); // JSON pour stocker des préférences supplémentaires
            
            $table->timestamps();
            
            // Contrainte d'unicité
            $table->unique(['courrier_id', 'user_id']);
            
            // Index
            $table->index(['courrier_id', 'type']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_followers');
    }
};
