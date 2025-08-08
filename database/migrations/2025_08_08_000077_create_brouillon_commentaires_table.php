<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brouillon_commentaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brouillon_id')->constrained('brouillons')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            
            // Contenu du commentaire
            $table->text('contenu');
            
            // Référence à un commentaire parent pour les réponses
            $table->foreignId('parent_id')->nullable()->constrained('brouillon_commentaires')->nullOnDelete();
            
            // Statut du commentaire (actif, supprimé, etc.)
            $table->enum('statut', ['actif', 'supprime'])->default('actif');
            
            $table->timestamps();
            
            // Index
            $table->index(['brouillon_id', 'parent_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('brouillon_commentaires');
    }
};
