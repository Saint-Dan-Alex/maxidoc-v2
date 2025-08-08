<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_partages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            
            // Type d'entité avec laquelle le courrier est partagé (utilisateur, service, etc.)
            $table->string('partageable_type'); // App\Models\User, App\Models\Service, etc.
            $table->unsignedBigInteger('partageable_id');
            
            // Droits d'accès
            $table->boolean('peut_voir')->default(true);
            $table->boolean('peut_modifier')->default(false);
            $table->boolean('peut_supprimer')->default(false);
            $table->boolean('peut_partager')->default(false);
            $table->boolean('peut_commenter')->default(true);
            
            // Dates de validité du partage
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            
            // Informations de suivi
            $table->foreignId('shared_by')->constrained('users');
            $table->text('raison')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['courrier_id', 'partageable_type', 'partageable_id'], 'courrier_share_index');
            $table->index('shared_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_partages');
    }
};
