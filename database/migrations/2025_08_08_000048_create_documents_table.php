<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('reference', 100)->unique();
            $table->text('description')->nullable();
            $table->foreignId('dossier_id')->constrained('dossiers')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('document_types');
            $table->foreignId('nature_id')->nullable()->constrained('document_natures')->nullOnDelete();
            $table->foreignId('statut_id')->constrained('document_statuts');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->boolean('est_public')->default(false);
            $table->boolean('est_verrouille')->default(false);
            $table->date('date_document')->nullable();
            $table->date('date_expiration')->nullable();
            $table->string('mot_cles')->nullable();
            $table->integer('version_majeure')->default(1);
            $table->integer('version_mineure')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['dossier_id', 'type_id', 'nature_id', 'statut_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
