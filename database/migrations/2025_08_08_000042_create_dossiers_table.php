<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('reference', 100)->unique()->nullable();
            $table->text('description')->nullable();
            $table->foreignId('classeur_id')->constrained('classeurs')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('dossiers')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('est_public')->default(false);
            $table->string('couleur', 20)->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['classeur_id', 'parent_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
};
