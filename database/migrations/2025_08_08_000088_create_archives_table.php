<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            
            // Type d'élément archivé (courrier, document, etc.)
            $table->string('archivable_type');
            $table->unsignedBigInteger('archivable_id');
            
            // Données de l'élément archivé (sérialisées en JSON)
            $table->json('data');
            
            // Métadonnées d'archivage
            $table->string('version', 50)->default('1.0');
            $table->string('format', 50)->default('json');
            $table->string('taille')->comment('Taille en octets');
            $table->string('checksum')->comment('Checksum pour vérification d\'intégrité');
            
            // Raison de l'archivage
            $table->string('raison', 100);
            $table->text('commentaire')->nullable();
            
            // Référence à l'utilisateur ayant effectué l'archivage
            $table->foreignId('archived_by')->constrained('users');
            
            // Référence à l'utilisateur ayant demandé l'archivage (peut être différent)
            $table->foreignId('requested_by')->nullable()->constrained('users');
            
            // Durée de rétention
            $table->date('date_archivage');
            $table->date('date_expiration')->nullable();
            
            // Statut de l'archive (actif, expiré, supprimé)
            $table->enum('statut', ['actif', 'expire', 'supprime'])->default('actif');
            
            // Emplacement physique (si stockage externe)
            $table->string('emplacement')->nullable();
            
            // Métadonnées techniques
            $table->string('compression', 50)->nullable();
            $table->string('encryption', 50)->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['archivable_type', 'archivable_id']);
            $table->index('archived_by');
            $table->index('date_archivage');
            $table->index('date_expiration');
            $table->index('statut');
        });
    }

    public function down()
    {
        Schema::dropIfExists('archives');
    }
};
