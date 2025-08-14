<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assistanats', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100);
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->boolean('for_dg')->default(false);
            $table->boolean('for_dga')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('direction_id');
            $table->index('responsable_id');

            $table->foreign('direction_id')->references('id')->on('directions')->nullOnDelete();
            $table->foreign('responsable_id')->references('id')->on('agents')->nullOnDelete();
        });
        DB::table('assistanats')->insert([
            [
                'titre' => 'Assistant du DG',
                'direction_id' => 1,
                'responsable_id' => null,
                'for_dg' => true,
                'for_dga' => false,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('assistanats');
    }
};
