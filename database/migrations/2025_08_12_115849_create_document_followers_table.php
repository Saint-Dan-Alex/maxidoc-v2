<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedInteger('traitement_id')->nullable();
            $table->unsignedInteger('send_by')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Clés étrangères
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_followers');
    }
};
