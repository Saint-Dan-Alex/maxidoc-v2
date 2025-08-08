<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_taches_cibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            
            // Type polymorphique pour gérer différents types de cibles
            $table->string('cible_type'); // Modèle cible (ex: App\Models\Courrier, App\Models\Document)
            $table->unsignedBigInteger('cible_id'); // ID de l'entité cible
            
            // Type de relation (lié à, impacte, dépend de, etc.)
            $table->string('type_relation', 50)->default('lie_a');
            
            // Métadonnées
            $table->text('commentaire')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index
            $table->index(['tache_id', 'cible_type', 'cible_id']);
            $table->index(['cible_type', 'cible_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_taches_cibles');
    }
};
