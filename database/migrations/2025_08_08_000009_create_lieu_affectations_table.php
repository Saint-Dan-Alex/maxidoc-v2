<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lieu_affectations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('lieu_affectations')->insert([
            ['titre' => 'Kinshasa-Limete', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Kinshasa-Maluku', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Matadi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lieu_affectations');
    }
};
