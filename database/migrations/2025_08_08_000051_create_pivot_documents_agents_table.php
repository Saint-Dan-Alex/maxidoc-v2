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
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->string('role', 50); // proprietaire, signataire, destinataire, etc.
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->unique(['document_id', 'agent_id', 'role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_documents_agents');
    }
};
