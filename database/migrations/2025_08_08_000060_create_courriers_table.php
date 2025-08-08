<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 100)->unique();
            $table->string('objet');
            $table->text('resume')->nullable();
            $table->enum('type', ['entrant', 'sortant', 'interne']);
            $table->enum('sous_type', ['courrier', 'note', 'rapport', 'autre'])->default('courrier');
            $table->enum('priorite', ['basse', 'normale', 'haute', 'urgente'])->default('normale');
            $table->enum('confidentialite', ['normal', 'confidentiel', 'tres_confidentiel'])->default('normal');
            
            // Relations
            $table->foreignId('categorie_id')->constrained('courrier_categories');
            $table->foreignId('nature_id')->nullable()->constrained('courrier_natures');
            $table->foreignId('type_id')->constrained('courrier_types');
            $table->foreignId('expediteur_id')->constrained('courrier_expediteurs');
            $table->foreignId('traitement_actuel_id')->nullable()->constrained('courrier_traitements');
            $table->foreignId('service_traitant_id')->nullable()->constrained('services');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            
            // Dates importantes
            $table->date('date_emission');
            $table->date('date_reception');
            $table->date('date_limite_traitement')->nullable();
            $table->date('date_cloture')->nullable();
            
            // Métadonnées
            $table->integer('nombre_pieces')->default(1);
            $table->string('mots_cles')->nullable();
            $table->string('fichier_joint')->nullable();
            $table->string('chemin_fichier')->nullable();
            $table->string('taille_fichier')->nullable();
            $table->string('format_fichier', 20)->nullable();
            
            // Statut et suivi
            $table->enum('statut', ['brouillon', 'en_cours', 'traite', 'cloture', 'annule'])->default('brouillon');
            $table->boolean('est_archive')->default(false);
            $table->date('date_archivage')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['reference', 'type', 'statut', 'date_reception', 'date_emission']);
            $table->index(['categorie_id', 'nature_id', 'type_id']);
            $table->index('expediteur_id');
            $table->index('service_traitant_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers');
    }
};
