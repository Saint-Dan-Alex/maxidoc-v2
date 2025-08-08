<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_taches_cibles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tache_id')->nullable();
            $table->unsignedBigInteger('cible_id')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // pour deleted_at

            // Index facultatif
            $table->index(['tache_id']);
            $table->index(['cible_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_taches_cibles');
    }
};
