<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_url', 255)->nullable();
            $table->enum('type_image', ['SIGNATURE', 'TAMPON', 'INITIALES'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('password', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
