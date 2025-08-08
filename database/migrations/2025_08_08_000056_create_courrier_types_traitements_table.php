<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_types_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('icone', 50)->nullable();
            $table->string('couleur', 20)->nullable();
            $table->integer('delai_jours')->nullable();
            $table->boolean('notification_actif')->default(false);
            $table->text('message_notification')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types_traitements');
    }
};
