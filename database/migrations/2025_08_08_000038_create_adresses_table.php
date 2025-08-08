<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('ligne1', 150);
            $table->string('ligne2', 150)->nullable();
            $table->string('code_postal', 20);
            $table->string('ville', 100);
            $table->string('pays', 100)->default('France');
            $table->boolean('principale')->default(false);
            $table->morphs('adressable');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['adressable_id', 'adressable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('adresses');
    }
};
