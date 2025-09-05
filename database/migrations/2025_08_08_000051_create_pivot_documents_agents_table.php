<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_documents_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->cascadeOnDelete();
            $table->foreignId('document_id')->nullable()->constrained('documents')->cascadeOnDelete();
            $table->timestamps();         // created_at, updated_at
            $table->softDeletes();        // deleted_at

            // Pas d'autres colonnes (comme role, dates, commentaire)
            // Pas d'index ou clé unique (non mentionné dans ta table SQL)
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_documents_agents');
    }
};
