<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour insérer les données

return new class extends Migration
{
    public function up()
    {
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->timestamps();
        });

        // Insérer les étapes par défaut
        DB::table('etapes')->insert([
            ['titre' => 'Service courrier', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Secrétariat général', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Assistant', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Direction général', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('etapes');
    }
};
