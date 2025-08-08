<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_destinateur_externes', function (Blueprint $table) {
            $table->id(); // int auto_increment primary key
            $table->string('nom', 255)->nullable()->collation('utf8mb3_general_ci'); // nullable et collation utf8mb3
            $table->timestamps(); // created_at et updated_at (nullable)
            $table->softDeletes(); // deleted_at (nullable)

            // Index optionnel selon ta table d'origine (sur nom uniquement ici)
            $table->index('nom');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_destinateur_externes');
    }
};
