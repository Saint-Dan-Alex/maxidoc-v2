<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('courriers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            
            // Contenu de l'annotation
            $table->text('contenu');
            $table->string('type', 50)->default('note'); // note, commentaire, correction, etc.
            $table->string('statut', 50)->default('actif'); // actif, archive, supprime
            
            // Position et mise en forme
            $table->string('page')->nullable(); // Pour les annotations sur des pages spécifiques
            $table->json('position')->nullable(); // Coordonnées x,y si applicable
            
            // Réponse à une autre annotation (pour les fils de discussion)
            $table->foreignId('parent_id')->nullable()->constrained('courriers_annotations')->nullOnDelete();
            
            // Visibilité
            $table->boolean('est_prive')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['courrier_id', 'type', 'statut']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_annotations');
    }
};
