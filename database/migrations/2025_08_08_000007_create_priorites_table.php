<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up()
    {
        Schema::create('priorites', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('priorites')->insert([
            ['titre' => 'Faible', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Moyenne', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Forte', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }

    public function down()
    {
        Schema::dropIfExists('priorites');
    }
};
