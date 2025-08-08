<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 20)->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naiss')->nullable();
            $table->string('lieu_naiss', 100)->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('photo', 255)->nullable();
            $table->foreignId('grade_id')->nullable()->constrained('grades')->nullOnDelete();
            $table->foreignId('fonction_id')->nullable()->constrained('fonctions')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('statut_id')->default(1)->constrained('statuts');
            $table->date('date_prise_service')->nullable();
            $table->date('date_retraite')->nullable();
            $table->string('compte_bancaire', 50)->nullable();
            $table->string('nom_banque', 100)->nullable();
            $table->string('nom_contact_urgence', 100)->nullable();
            $table->string('tel_contact_urgence', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['grade_id', 'fonction_id', 'service_id', 'statut_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('agents');
    }
};
