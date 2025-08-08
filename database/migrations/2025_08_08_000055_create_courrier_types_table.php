<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_types', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('prefixe', 20)->nullable();
            $table->string('suffixe', 20)->nullable();
            $table->integer('prochain_numero')->default(1);
            $table->boolean('increment_auto')->default(true);
            $table->string('format_numero', 100)->default('{PREFIXE}{ANNEE}{NUMERO}');
            $table->boolean('est_actif')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types');
    }
};
