<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour insérer

return new class extends Migration
{
    public function up()
    {
        Schema::create('etats', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('statut_id')->default(1)->constrained('statuts');
        });

        // Insérer les états par défaut
        DB::table('etats')->insert([
            ['libelle' => 'Priorité absolu', 'user_id' => 1, 'statut_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Urgent', 'user_id' => 1, 'statut_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Normal', 'user_id' => 1, 'statut_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('etats');
    }
};
