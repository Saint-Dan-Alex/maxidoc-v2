<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->foreignId('type_traitement_id')->constrained('courrier_types_traitements');
            $table->date('date_debut')->nullable();
            $table->date('date_echeance')->nullable();
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'annule'])->default('en_attente');
            $table->integer('priorite')->default(2); // 1: Haute, 2: Normale, 3: Basse
            $table->boolean('est_confidentiel')->default(false);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type_traitement_id', 'statut', 'priorite']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_traitements');
    }
};
