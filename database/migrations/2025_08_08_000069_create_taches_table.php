<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->index(); // selon ta colonne 2
            $table->foreignId('statut_id')->nullable()->default(1); // colonne 3
            $table->foreignId('tache_statut_id')->nullable()->default(1); // colonne 4
            $table->foreignId('priorite_id')->nullable(); // colonne 5
            $table->foreignId('parent_id')->nullable(); // colonne 6

            $table->string('titre', 255)->nullable(); // colonne 7
            $table->integer('pourcentage')->default(0); // colonne 8 (progression)
            $table->text('description')->nullable(); // colonne 9

            $table->timestamp('date_debut')->nullable(); // colonne 10
            $table->timestamp('date_fin')->nullable(); // colonne 11

            $table->foreignId('courrier_id')->nullable()->constrained('courriers')->nullOnDelete(); // colonne 15

            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at

            // Indexes utiles (ajoute selon besoins)
            $table->index(['statut_id', 'date_fin']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches');
    }
};
