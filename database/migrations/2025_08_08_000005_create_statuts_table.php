<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('statuts', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertion des statuts par défaut
        DB::table('statuts')->insert([
            [
                'libelle' => 'En attente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'En cours',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Traité',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('statuts');
    }
};
