<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // 🔹 Informations générales
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('courrier_categories')->nullOnDelete();
            $table->string('reference', 255)->nullable();
            $table->string('reference_courrier', 200)->nullable();
            $table->string('reference_interne', 200)->nullable();
            $table->string('libelle', 255)->nullable();
            $table->text('title')->nullable();
            $table->text('redacteur')->nullable();
            $table->foreignId('type')->nullable()->constrained('document_types')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('objet')->nullable();
            $table->text('observations')->nullable();
            $table->text('document')->nullable(); // JSON des fichiers

            // 🔹 Dates
            $table->timestamp('date_du_courrier')->nullable();
            $table->timestamp('date_arrive')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamp('desarchive_at')->nullable();

            // 🔹 Confidentialité
            $table->boolean('confidentiel')->default(false);
            $table->boolean('is_classified')->default(false);
            $table->string('password', 255)->nullable();

            // 🔹 Relations utilisateur
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('desarchive_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('statut_id')->default(1)->constrained('document_statuts');
            $table->foreignId('priorite_id')->nullable()->constrained('priorites')->nullOnDelete();
            $table->foreignId('nature_id')->nullable()->constrained('courrier_natures')->nullOnDelete();
            $table->foreignId('traitement_id')->nullable()->constrained('courrier_traitements')->nullOnDelete();
            $table->foreignId('courrier_id')
                  ->nullable()
                ->constrained('courriers')
                  ->nullOnDelete();

            // 🔹 Expéditeur
            // $table->text('expediteur_externe')->nullable(); // Ex: entreprise, particulier
            $table->foreignId('expediteur_interne_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('expediteur_externe')->nullable()->constrained('courrier_expediteurs')->nullOnDelete();

            // 🔹 Destinataire
            $table->foreignId('destinataire_externe_id')->nullable()->constrained('courrier_destinateur_externes')->nullOnDelete();
            $table->foreignId('destinataire_interne_id')->nullable()->constrained('agents')->nullOnDelete();

            // 🔹 Hiérarchie et liens
            $table->foreignId('reference_document_id')->nullable()->constrained('documents')->nullOnDelete();
            $table->foreignId('parent_document_id')->nullable()->constrained('documents')->nullOnDelete();

            // 🔹 États et workflow
            $table->boolean('is_piece_jointe')->default(false);
            $table->boolean('is_default')->default(false);
            $table->boolean('mark_as_done')->nullable();
            $table->string('etape', 50)->default('en_attente');

            // 🔹 Copie
            $table->integer('copie')->nullable();

            // 🔹 Timestamps
            $table->timestamps();
            $table->softDeletes();

            // 🔹 Index
            $table->index(['user_id']);
            $table->index(['statut_id']);
            $table->index(['reference_interne']);
            $table->index(['date_arrive']);
            $table->index(['date_du_courrier']);
            $table->index(['etape']);
            $table->index(['mark_as_done']);
            $table->index(['is_classified']);
            $table->index(['expediteur_interne_id']);
            $table->index(['destinataire_interne_id']);
            $table->index(['destinataire_externe_id']);
        });

        // 🔴 Création du dossier mensuel pour les documents
        $yearMonth = now()->format('FY'); // Ex: August2025
        $destinationPath = storage_path('app/public/documents/' . $yearMonth);
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Fonction de copie des fichiers par défaut
        $copyFile = function ($sourceFile) use ($yearMonth, $destinationPath) {
            $sourcePath = storage_path('app/public/documents_defaut/' . $sourceFile);
            if (!File::exists($sourcePath)) {
                throw new \Exception("Fichier manquant : " . $sourcePath);
            }

            $fileName = Str::random(20) . '.pdf';
            $fullDestinationPath = $destinationPath . '/' . $fileName;

            File::copy($sourcePath, $fullDestinationPath);

            return [
                'download_link' => 'documents/' . $yearMonth . '/' . $fileName,
                'original_name' => $sourceFile,
            ];
        };

        // Insertion des documents par défaut
        $documents = [
            [
                'dossier_id' => 1,
                'category_id' => null,
                'reference' => null,
                'libelle' => "Bienvenue sur MAXIDOC®.pdf",
                'type' => 1,
                'description' => null,
                'document' => json_encode([
                    $copyFile("Bienvenue sur MAXIDOC®.pdf")
                ]),
                'confidentiel' => false,
                'password' => null,
                'user_id' => 1,
                'statut_id' => 5,
                'created_by' => 1,
                'archived_at' => null,
                'desarchive_by' => null,
                'desarchive_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_piece_jointe' => false,
                'is_default' => true,
                'reference_document_id' => null,
                'title' => null,
                'reference_courrier' => null,
                'reference_interne' => null,
                'objet' => null,
                'date_du_courrier' => null,
                'date_arrive' => null,
                'date_fin' => null,
                'priorite_id' => null,
                'nature_id' => null,
                'traitement_id' => null,
                'expediteur_externe' => null,
                'expediteur_interne_id' => null,
                'destinataire_externe_id' => null,
                'destinataire_interne_id' => null,
                'is_classified' => false,
                'mark_as_done' => null,
                'etape' => 'en_attente',
                'copie' => null,
                'parent_document_id' => null,
            ],
            [
                'dossier_id' => 1,
                'category_id' => null,
                'reference' => null,
                'libelle' => "GUIDE DUTILISATION - Premiers pas avec MAXIDOC®",
                'type' => 1,
                'description' => null,
                'document' => json_encode([
                    $copyFile("GUIDE DUTILISATION - Premiers pas avec MAXIDOC®.pdf")
                ]),
                'confidentiel' => false,
                'password' => null,
                'user_id' => 1,
                'statut_id' => 5,
                'created_by' => 1,
                'archived_at' => null,
                'desarchive_by' => null,
                'desarchive_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_piece_jointe' => false,
                'is_default' => true,
                'reference_document_id' => null,
                'title' => null,
                'reference_courrier' => null,
                'reference_interne' => null,
                'objet' => null,
                'date_du_courrier' => null,
                'date_arrive' => null,
                'date_fin' => null,
                'priorite_id' => null,
                'nature_id' => null,
                'traitement_id' => null,
                'expediteur_externe' => null,
                'expediteur_interne_id' => null,
                'destinataire_externe_id' => null,
                'destinataire_interne_id' => null,
                'is_classified' => false,
                'mark_as_done' => null,
                'etape' => 'en_attente',
                'copie' => null,
                'parent_document_id' => null,
            ]
        ];

        DB::table('documents')->insert($documents);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};