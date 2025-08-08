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
            
            $table->string('type_relation', 50)->default('piece_jointe');
            $table->text('commentaire')->nullable();
            $table->string('version_document', 50)->nullable();
            
            $table->foreignId('created_by')->constrained('users');
            
            $table->timestamps();
            
            $table->unique(['tache_id', 'document_id', 'type_relation'], 'tache_document_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tache_documents');
    }
};
