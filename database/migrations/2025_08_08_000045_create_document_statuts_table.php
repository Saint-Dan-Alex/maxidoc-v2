<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_statuts', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('couleur', 20)->nullable();
            $table->string('icone', 50)->nullable();
            $table->boolean('est_par_defaut')->default(false);
            $table->boolean('peut_modifier')->default(true);
            $table->boolean('peut_supprimer')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_statuts');
    }
};
