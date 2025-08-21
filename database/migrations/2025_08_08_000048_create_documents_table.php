<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->nullable()->constrained('dossiers')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('courrier_categories')->nullOnDelete();
            $table->string('reference', 255)->nullable();
            $table->string('libelle', 255)->nullable();
            $table->foreignId('type')->nullable()->constrained('document_types')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('document')->nullable(); // Stockera une chaîne JSON
            $table->boolean('confidentiel')->default(false);
            $table->string('password', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('statut_id')->default(1)->constrained('document_statuts');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('desarchive_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('desarchive_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_piece_jointe')->default(false);
            $table->boolean('is_default')->default(false);
            $table->foreignId('reference_document_id')->nullable()->constrained('documents')->nullOnDelete();

            // Indexes
            $table->index(['user_id']);
            $table->index(['statut_id']);
        });

        // Format du mois : "F Y" → "August 2025"
        $yearMonth = now()->format('F Y');
        $destinationPath = storage_path('app/public/documents/' . $yearMonth);

        // Créer le dossier s'il n'existe pas
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Fonction pour copier le fichier et générer les infos
        // 🔴 Correction ici : ajout de $destinationPath dans le `use`
        $copyFile = function ($sourceFile) use ($yearMonth, $destinationPath) {
            $sourcePath = storage_path('app/public/documents_defaut/' . $sourceFile);

            if (!File::exists($sourcePath)) {
                throw new \Exception("Le fichier source n'existe pas : " . $sourcePath);
            }

            $fileName = Str::random(20) . '.pdf';
            $fullDestinationPath = $destinationPath . '/' . $fileName;

            // Copie du fichier
            File::copy($sourcePath, $fullDestinationPath);

            return [
                'download_link' => 'documents/' . $yearMonth . '/' . $fileName,
                'original_name' => $sourceFile,
            ];
        };

        // Préparation des documents par défaut
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
            ]
        ];

        // Insertion en base
        DB::table('documents')->insert($documents);
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};