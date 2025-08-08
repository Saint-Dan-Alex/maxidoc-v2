<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->foreignId('type_id')->constrained('document_types');
            $table->string('fichier');
            $table->string('chemin');
            $table->string('taille');
            $table->string('version', 20)->default('1.0');
            $table->boolean('est_actif')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_templates');
    }
};
