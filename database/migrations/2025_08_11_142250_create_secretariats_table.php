<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secretariats', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100);
            $table->foreignId('direction_id')->nullable()->constrained('directions')->onDelete('set null');
            $table->foreignId('responsable_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->boolean('for_dg')->default(false);
            $table->boolean('for_dga')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('secretariats')->insert([
            [
                'titre' => 'Service Accueil',
                'direction_id' => 1,
                'responsable_id' => null,
                'for_dg' => true,
                'for_dga' => false,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secretariats');
    }
};
