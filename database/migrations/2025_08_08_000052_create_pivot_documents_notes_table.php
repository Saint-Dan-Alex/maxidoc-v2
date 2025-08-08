<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_documents_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->constrained('documents')->cascadeOnDelete();
            $table->foreignId('note_id')->nullable()->constrained('document_notes')->cascadeOnDelete();
            $table->timestamps();       // created_at, updated_at
            $table->softDeletes();      // deleted_at
            
            // Pas d'unicité sur ['document_id', 'note_id'] car non indiquée dans ta table SQL
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_documents_notes');
    }
};
