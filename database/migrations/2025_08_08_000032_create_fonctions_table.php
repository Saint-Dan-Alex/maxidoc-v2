<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fonctions', function (Blueprint $table) {
            $table->id();

            $table->string('titre')->nullable(); // nullable pour correspondre à la DB
            $table->text('description')->nullable();

            // Clés étrangères
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->foreignId('direction_id')->nullable()->constrained('directions')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Index optionnels si utilisés dans les requêtes
            $table->index('service_id');
            $table->index('section_id');
            $table->index('division_id');
            $table->index('direction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fonctions');
    }
};
