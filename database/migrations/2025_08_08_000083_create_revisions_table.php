<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();

            $table->string('revisionable_type')->index();
            $table->unsignedBigInteger('revisionable_id')->index();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();

            $table->string('key')->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisions');
    }
};
