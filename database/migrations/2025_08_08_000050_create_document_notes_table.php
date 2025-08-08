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
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->string('titre')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ajoute la colonne deleted_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_notes');
    }
};
