<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_agent_fonctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('fonction_id')->constrained('fonctions')->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('actuel')->default(true);
            $table->text('commentaire')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['agent_id', 'fonction_id', 'date_debut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_agent_fonctions');
    }
};
