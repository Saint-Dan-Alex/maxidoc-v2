<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tache_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id');
            $table->timestamp('viewed_at')->nullable();           // ✅ Re-ajoutée
            $table->boolean('is_first_view')->default(true); // ✅ Gardée
            $table->timestamps();                     // created_at & updated_at

            // Clés étrangères
            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');

            // Clé unique pour éviter les doublons
            $table->unique(['tache_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tache_views');
    }
};