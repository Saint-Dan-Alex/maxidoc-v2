<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->text('contenu');
            $table->boolean('est_public')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['document_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_notes');
    }
};
