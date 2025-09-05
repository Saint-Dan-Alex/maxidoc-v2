<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brouillon_commentaires', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('brouillon_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Index simples (non foreign keys ici car non précisé dans ta structure SQL)
            $table->index('brouillon_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brouillon_commentaires');
    }
};
