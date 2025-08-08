<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brouillons', function (Blueprint $table) {
            $table->id();
            
            // Type de brouillon (courrier, document, etc.)
            $table->string('type', 50);
            
            // Données du brouillon (stockées en JSON pour plus de flexibilité)
            $table->json('contenu');
            
            // Métadonnées
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            
            // Référence à l'utilisateur propriétaire du brouillon
            $table->foreignId('user_id')->constrained('users');
            
            // Si le brouillon est lié à un élément existant (ex: édition d'un courrier)
            $table->string('modele_type')->nullable();
            $table->unsignedBigInteger('modele_id')->nullable();
            
            // Dernière modification
            $table->timestamp('derniere_modification')->useCurrent();
            
            // Statut du brouillon (en_cours, archive, supprime)
            $table->enum('statut', ['en_cours', 'archive', 'supprime'])->default('en_cours');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['user_id', 'type', 'statut']);
            $table->index(['modele_type', 'modele_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('brouillons');
    }
};
