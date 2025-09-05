<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('accuse_receptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('courrier_id')->nullable()->constrained('courriers')->nullOnDelete();
            $table->timestamps();

            // Indexation simple
            $table->index('user_id');
            $table->index('courrier_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('accuse_receptions');
    }
};
