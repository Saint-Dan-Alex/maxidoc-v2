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
            $table->string('titre');
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('est_public')->default(false);
            $table->string('couleur', 20)->nullable();
            $table->string('icone', 50)->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['service_id', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classeurs');
    }
};
