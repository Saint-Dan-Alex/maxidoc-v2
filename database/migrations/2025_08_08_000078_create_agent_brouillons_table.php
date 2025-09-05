<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agent_brouillons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('brouillon_id')->nullable();
            $table->timestamps();

            // Index
            $table->index('agent_id');
            $table->index('brouillon_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agent_brouillons');
    }
};
