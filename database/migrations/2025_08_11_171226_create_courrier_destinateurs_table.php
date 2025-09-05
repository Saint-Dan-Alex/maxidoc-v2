<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courrier_destinateurs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('courrier_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Clés étrangères
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('courrier_id')->references('id')->on('courriers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courrier_destinateurs');
    }
};
