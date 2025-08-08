<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_etapes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            $table->foreignId('etape_id')->constrained('etapes');
            $table->foreignId('agent_id')->constrained('agents');
            
            // Statut de l'étape pour ce courrier
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'rejete'])->default('en_attente');
            
            // Dates importantes
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            $table->dateTime('date_echeance')->nullable();
            
            // Commentaires et décision
            $table->text('commentaire')->nullable();
            $table->string('decision', 100)->nullable();
            
            // Référence à l'étape précédente (pour le workflow)
            $table->foreignId('etape_precedente_id')->nullable()->constrained('courriers_etapes')->nullOnDelete();
            
            // Signature électronique
            $table->string('signature_hash', 255)->nullable();
            $table->dateTime('date_signature')->nullable();
            
            // Suivi
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index
            $table->index(['courrier_id', 'etape_id', 'statut']);
            $table->index(['agent_id', 'statut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_etapes');
    }
};
