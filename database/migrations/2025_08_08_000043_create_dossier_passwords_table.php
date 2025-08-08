<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossier_passwords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->nullOnDelete();
            $table->string('password')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('dossier_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossier_passwords');
    }
};
