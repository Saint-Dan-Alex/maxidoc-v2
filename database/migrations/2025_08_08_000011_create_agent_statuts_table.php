<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // pour DB::table()

return new class extends Migration
{
    public function up()
    {
        Schema::create('agent_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insérer les statuts par défaut
        DB::table('agent_statuts')->insert([
            ['titre' => 'Actif', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Inactif', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Archivé', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('agent_statuts');
    }
};
