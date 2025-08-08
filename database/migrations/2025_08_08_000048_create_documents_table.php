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
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('reference', 255)->nullable();
            $table->string('libelle', 255)->nullable();
            $table->foreignId('type')->nullable()->constrained('document_types')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('document', 255)->nullable();
            $table->boolean('confidentiel')->default(false);
            $table->string('password', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('statut_id')->default(1)->constrained('document_statuts');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('archived_at')->useCurrent();
            $table->foreignId('desarchive_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('desarchive_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_piece_jointe')->default(false);

            // Indexes
            $table->index(['user_id']);
            $table->index(['statut_id']);
            $table->index(['reference_document_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
