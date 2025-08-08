<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_natures', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100)->nullable()->collation('utf8mb3_general_ci');
            $table->longText('modele')->nullable()->collation('utf8mb3_general_ci');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_natures');
    }
};
