<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle'); // obligatoire
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->string('responsable_id', 255)->nullable();
            $table->unsignedBigInteger('statut_id')->default(1);

            $table->timestamps();

            $table->index('direction_id');
            $table->index('statut_id');

            $table->foreign('direction_id')->references('id')->on('directions')->nullOnDelete();
            $table->foreign('statut_id')->references('id')->on('statuts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisions');
    }
};
