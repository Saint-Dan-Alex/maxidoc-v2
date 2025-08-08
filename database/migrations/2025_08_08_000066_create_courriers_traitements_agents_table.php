<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_traitements_agents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('courrier_id')->nullable();
            $table->unsignedBigInteger('traitement_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_traitements_agents');
    }
};
