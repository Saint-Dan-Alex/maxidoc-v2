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
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('note_id')->constrained('document_notes')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->unique(['document_id', 'note_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_documents_notes');
    }
};
