<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archive_permissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('agent_id')->index();

            $table->unsignedBigInteger('permissionable_id')->nullable();
            $table->string('permissionable_type')->nullable();

            $table->string('key', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Optionnel : clé étrangère si agent_id réfère à users ou agents
            // $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_permissions');
    }
};
