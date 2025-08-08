<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brouillons', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->integer('type')->nullable();
            $table->text('content')->nullable();
            $table->string('participants')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Index (optionnel mais courant)
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brouillons');
    }
};
