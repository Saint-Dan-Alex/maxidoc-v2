<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100)->nullable();
            $table->string('fichier');
            $table->string('chemin');
            $table->string('type_mime', 50);
            $table->integer('taille')->unsigned();
            $table->integer('largeur')->nullable();
            $table->integer('hauteur')->nullable();
            $table->text('description')->nullable();
            $table->morphs('imageable');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['imageable_id', 'imageable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
