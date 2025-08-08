<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour les insertions

return new class extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->timestamps();
        });

        // Insertion des modules par défaut
        DB::table('modules')->insert([
            ['titre' => 'Tableau de bord', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Courriers', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Tâches', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Documents', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Archivage', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Employés', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Parametres', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
