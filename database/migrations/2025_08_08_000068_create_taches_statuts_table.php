<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taches_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->string('couleur', 20)->default('#6c757d');
            $table->string('icone', 50)->default('circle');
            $table->boolean('est_termine')->default(false);
            $table->boolean('est_actif')->default(true);
            $table->integer('ordre_affichage')->default(0);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches_statuts');
    }
};
