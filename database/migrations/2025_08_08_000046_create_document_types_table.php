<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insérer les types de document par défaut
        DB::table('document_types')->insert([
            ['titre' => 'Entrant', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Sortant', 'created_at' => now(), 'updated_at' => now()],
            ['titre' => 'Interne', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('document_types');
    }
};
