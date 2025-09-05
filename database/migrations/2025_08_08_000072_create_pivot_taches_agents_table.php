<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_taches_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            
            // Champs personnalisés présents dans ta table
            $table->string('type')->nullable(); // Peut représenter un type de lien ou rôle
            $table->string('type_id')->nullable(); // Peut représenter une clé ou référence liée au type
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_taches_agents');
    }
};
