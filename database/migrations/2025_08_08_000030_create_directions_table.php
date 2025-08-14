<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('lieu_id')->default(12);
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('adjoint_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('directions');
    }
};
