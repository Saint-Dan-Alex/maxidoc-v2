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
            
            // Type d'entité (user, role, etc.)
            $table->string('permissible_type');
            $table->unsignedBigInteger('permissible_id');
            
            // Type d'archive (courrier, document, etc.)
            $table->string('archive_type');
            
            // Droits d'accès
            $table->boolean('peut_voir')->default(false);
            $table->boolean('peut_telecharger')->default(false);
            $table->boolean('peut_supprimer')->default(false);
            $table->boolean('peut_restaurer')->default(false);
            
            // Période de validité
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            
            // Restrictions supplémentaires
            $table->json('restrictions')->nullable();
            
            // Métadonnées
            $table->foreignId('created_by')->constrained('users');
            $table->text('raison')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['permissible_type', 'permissible_id']);
            $table->index('archive_type');
            $table->index(['date_debut', 'date_fin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_permissions');
    }
};
