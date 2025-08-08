<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_destinateur_externes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('fonction')->nullable();
            $table->string('entreprise')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('pays', 100)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['nom', 'prenom', 'entreprise']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_destinateur_externes');
    }
};
