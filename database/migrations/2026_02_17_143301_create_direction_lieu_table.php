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
        Schema::create('direction_lieu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direction_id')->constrained()->onDelete('cascade');
            $table->foreignId('lieu_id')->constrained('lieu_affectations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direction_lieu');
    }
};
