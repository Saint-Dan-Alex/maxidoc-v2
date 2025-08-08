<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            
            // Contenu du commentaire
            $table->text('contenu');
            
            // Type de commentaire (général, système, mise à jour, etc.)
            $table->string('type', 50)->default('general');
            
            // Statut du commentaire (publié, modéré, supprimé, etc.)
            $table->enum('statut', ['publie', 'modere', 'supprime'])->default('publie');
            
            // Référence à l'utilisateur qui a créé le commentaire
            $table->foreignId('user_id')->constrained('users');
            
            // Référence au parent pour les réponses imbriquées
            $table->foreignId('parent_id')->nullable()->constrained('commentaires')->nullOnDelete();
            
            // Champs polymorphes pour lier à différents modèles
            $table->string('commentable_type'); // Ex: App\Models\Courrier, App\Models\Tache, etc.
            $table->unsignedBigInteger('commentable_id');
            
            // Métadonnées
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            // Modération
            $table->foreignId('modere_par')->nullable()->constrained('users');
            $table->text('raison_moderation')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['commentable_type', 'commentable_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentaires');
    }
};
