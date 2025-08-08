<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tache_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            
            // Type de relation (livrable, référence, pièce jointe, etc.)
            $table->string('type_relation', 50)->default('piece_jointe');
            
            // Commentaire sur cette relation
            $table->text('commentaire')->nullable();
            
            // Version du document au moment de l'ajout
            $table->string('version_document', 50)->nullable();
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index
            $table->unique(['tache_id', 'document_id', 'type_relation'], 'tache_document_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tache_documents');
    }
};
