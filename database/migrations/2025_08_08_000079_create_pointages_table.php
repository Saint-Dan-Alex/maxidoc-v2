<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->string('date');              // varchar(255), NOT NULL
            $table->string('arrive');            // varchar(255), NOT NULL
            $table->string('supplementaire', 5)->default('00:00');  // varchar(5), NOT NULL
            $table->string('majoree', 5)->default('00:00');         // varchar(5), NOT NULL
            $table->timestamps();                // created_at, updated_at nullable
            
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('agent_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pointages');
    }
};
