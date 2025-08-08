<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('sigle', 50)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('direction_id')->nullable()->constrained('directions')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('direction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisions');
    }
};
