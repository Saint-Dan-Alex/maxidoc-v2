<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 50)->nullable(); // longueur et nullable d'après ta table
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches_statuts');
    }
};
