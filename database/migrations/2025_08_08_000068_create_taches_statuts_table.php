<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertion des statuts par défaut
        $statuts = [
            ['titre' => 'Initial', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'En cours', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Fini', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Hors délai', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('taches_statuts')->insert($statuts);
    }

    public function down()
    {
        Schema::dropIfExists('taches_statuts');
    }
};
