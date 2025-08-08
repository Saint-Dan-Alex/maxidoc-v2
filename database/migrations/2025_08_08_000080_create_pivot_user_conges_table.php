<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_user_conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Période de congé
            $table->date('date_debut');
            $table->date('date_fin');
            
            // Type de congé (annuel, maladie, formation, etc.)
            $table->string('type_conge', 50);
            
            // Statut de la demande (en_attente, approuve, refuse, annule)
            $table->enum('statut', ['en_attente', 'approuve', 'refuse', 'annule'])->default('en_attente');
            
            // Détails de la demande
            $table->text('motif')->nullable();
            $table->text('commentaire')->nullable();
            
            // Gestion des approbations
            $table->foreignId('approuve_par')->nullable()->constrained('users');
            $table->dateTime('date_approbation')->nullable();
            $table->text('motif_refus')->nullable();
            
            // Données de suivi
            $table->integer('duree_jours')->virtualAs('DATEDIFF(date_fin, date_debut) + 1');
            $table->boolean('est_paye')->default(true);
            
            // Référence à un document justificatif
            $table->foreignId('document_id')->nullable()->constrained('documents');
            
            $table->timestamps();
            
            // Index
            $table->index(['user_id', 'date_debut', 'date_fin']);
            $table->index(['type_conge', 'statut']);
            $table->index('approuve_par');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_user_conges');
    }
};
