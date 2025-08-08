<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_destinataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            
            // Destinataire (interne ou externe)
            $table->enum('type', ['interne', 'externe']);
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('destinataire_externe_id')->nullable()->constrained('courrier_destinataire_externes')->nullOnDelete();
            
            // Informations spécifiques au destinataire
            $table->enum('statut', ['en_attente', 'lu', 'traite', 'rejete'])->default('en_attente');
            $table->dateTime('date_lecture')->nullable();
            $table->text('commentaire')->nullable();
            
            // Pour les envois groupés
            $table->boolean('est_principal')->default(false);
            $table->integer('ordre')->default(0);
            
            // Suivi
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index
            $table->index(['courrier_id', 'type', 'statut']);
            $table->index(['agent_id', 'destinataire_externe_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_destinataires');
    }
};
