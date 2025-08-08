<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direction_id')->nullable()->constrained('directions')->nullOnDelete();
            $table->string('titre')->nullable();
            $table->string('reference'); // correspond au champ non nullable
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('direction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classeurs');
    }
};
