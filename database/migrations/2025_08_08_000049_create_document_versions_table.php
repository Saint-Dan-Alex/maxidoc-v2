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
            $table->foreignId('original_document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('new_document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->index(['original_document_id', 'new_document_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_versions');
    }
};
