<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('phone_2', 25)->nullable();
            $table->string('email', 150)->nullable()->index();
            $table->text('residence')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Optionnel : clé étrangère agent_id si souhaitée
            $table->foreign('agent_id')->references('id')->on('agents')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adresses');
    }
};
