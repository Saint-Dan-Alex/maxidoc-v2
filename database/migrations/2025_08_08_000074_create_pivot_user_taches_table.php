<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_user_taches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('tache_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->unsignedBigInteger('statut_id')->default(1)->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_user_taches');
    }
};
