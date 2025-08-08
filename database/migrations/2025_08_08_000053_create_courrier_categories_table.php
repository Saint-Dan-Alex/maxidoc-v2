<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_categories', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('couleur', 20)->nullable();
            $table->string('icone', 50)->nullable();
            $table->boolean('est_actif')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_categories');
    }
};
