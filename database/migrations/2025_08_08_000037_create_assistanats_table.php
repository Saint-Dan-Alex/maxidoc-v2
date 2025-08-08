<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assistanats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('fonction_id')->nullable()->constrained('fonctions')->nullOnDelete();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['agent_id', 'fonction_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assistanats');
    }
};
