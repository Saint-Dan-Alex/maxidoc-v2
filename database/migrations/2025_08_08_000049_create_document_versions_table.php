<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->integer('version_majeure');
            $table->integer('version_mineure');
            $table->string('fichier');
            $table->string('chemin');
            $table->string('taille');
            $table->string('hash', 64);
            $table->foreignId('created_by')->constrained('users');
            $table->text('commentaire')->nullable();
            $table->boolean('est_courante')->default(false);
            $table->timestamps();
            
            $table->unique(['document_id', 'version_majeure', 'version_mineure']);
            $table->index(['document_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_versions');
    }
};
