<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            
            $table->string('key')->nullable();
            
            $table->unsignedBigInteger('historiquecable_id')->nullable();
            $table->string('historiquecable_type')->nullable();
            
            $table->text('description')->nullable();
            
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->index();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historiques');
    }
};
