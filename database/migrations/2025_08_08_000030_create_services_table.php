<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('statut_id')->nullable()->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('services')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_id');
            $table->index('direction_id');
            $table->index('division_id');
            $table->index('responsable_id');
            $table->index('statut_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
