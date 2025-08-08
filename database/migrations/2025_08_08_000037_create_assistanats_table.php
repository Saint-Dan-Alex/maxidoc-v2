<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assistanats', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100);
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->boolean('for_dg')->default(false);
            $table->boolean('for_dga')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('direction_id');
            $table->index('responsable_id');

            $table->foreign('direction_id')->references('id')->on('directions')->nullOnDelete();
            $table->foreign('responsable_id')->references('id')->on('agents')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assistanats');
    }
};
