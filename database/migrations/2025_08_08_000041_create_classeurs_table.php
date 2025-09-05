<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direction_id')->nullable()->constrained('directions')->nullOnDelete();
            $table->string('titre')->nullable();
            $table->string('reference');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('direction_id');
        });

        // Insert classeur par défaut
        DB::table('classeurs')->insert([
            'direction_id' => null,
            'titre' => 'Classeur par défaut',
            'reference' => 'DEF-CLASSEUR-001',
            'description' => 'Classeur créé automatiquement pour les documents par défaut',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('classeurs');
    }
};
