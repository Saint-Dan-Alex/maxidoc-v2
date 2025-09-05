<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->integer('responsable_id')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('statut_id')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('division_id');
            $table->index('service_id');
            $table->index('statut_id');

            $table->foreign('division_id')->references('id')->on('divisions')->nullOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
            $table->foreign('statut_id')->references('id')->on('statuts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
