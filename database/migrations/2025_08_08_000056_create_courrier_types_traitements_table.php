<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_types_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255)->nullable()->collation('utf8mb3_general_ci');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types_traitements');
    }
};
