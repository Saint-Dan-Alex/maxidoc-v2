<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 20);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('grades')->insert([
            ['titre' => 'Directeur Générale', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Directeur', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Manager', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Superviseur', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Agent', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
