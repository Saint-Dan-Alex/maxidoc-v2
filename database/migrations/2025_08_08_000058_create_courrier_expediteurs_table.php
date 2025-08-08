<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_expediteurs', function (Blueprint $table) {
            $table->id(); // int auto-increment primary key
            $table->unsignedBigInteger('category_id')->nullable(); // category_id int nullable
            $table->string('nom', 25)->nullable()->collation('utf8mb3_general_ci'); // nom varchar(25), nullable, collation utf8mb3_general_ci
            $table->timestamps(); // created_at et updated_at nullable
            $table->softDeletes(); // deleted_at nullable
            
            $table->index('category_id'); // index sur category_id
            $table->index('nom'); // index sur nom si besoin
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_expediteurs');
    }
};
