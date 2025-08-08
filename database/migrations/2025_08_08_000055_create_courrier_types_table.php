<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_types', function (Blueprint $table) {
            $table->id(); // bigint, primary key, auto increment
            $table->string('titre', 20)->nullable()->collation('utf8mb3_general_ci');
            $table->timestamps(); // created_at and updated_at, nullable
            // Pas de softDeletes, ni autres colonnes selon ta table
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types');
    }
};
