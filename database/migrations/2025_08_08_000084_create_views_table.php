<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id();

            $table->string('viewable_type')->index();
            $table->unsignedBigInteger('viewable_id')->index();

            $table->text('visitor')->nullable();
            $table->string('collection')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            // Timestamp avec valeur par défaut CURRENT_TIMESTAMP
            $table->timestamp('viewed_at')->useCurrent();

            // Clé étrangère optionnelle sur user_id si tu veux
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            // Pas de timestamps automatiques created_at/updated_at car absents de la table SQL
        });
    }

    public function down()
    {
        Schema::dropIfExists('views');
    }
};
