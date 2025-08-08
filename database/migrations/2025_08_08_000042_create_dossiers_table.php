<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classeur_id')->nullable()->constrained('classeurs')->nullOnDelete();
            $table->string('reference')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->integer('confidentiel')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['classeur_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
};
