<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tache_objectifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('taches')->cascadeOnDelete();
            $table->string('libelle');
            $table->text('description')->nullable();
            
            // Statut de l'objectif
            $table->boolean('est_termine')->default(false);
            $table->dateTime('date_realisation')->nullable();
            
            // Priorité et ordre
            $table->integer('priorite')->default(0);
            $table->integer('ordre_affichage')->default(0);
            
            // Suivi
            $table->foreignId('termine_par')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['tache_id', 'est_termine', 'priorite']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tache_objectifs');
    }
};
