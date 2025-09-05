<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique(); // Limit to 191 characters for MySQL compatibility
            $table->string('guard_name', 191)->default('web'); // Limit to 191 characters for MySQL compatibility
            $table->foreignId('module_id')->nullable()->constrained('modules')->nullOnDelete();
            $table->timestamps();
            
            // Create a custom index with explicit lengths for MySQL compatibility
            // $table->unique([
            //     'name',
            //     'guard_name'
            // ], 'permissions_name_guard_name_unique');
        });

        // Insertion directe des permissions
        $permissions = [
            ['name' => 'Voir le tableau de bord', 'guard_name' => 'web', 'module_id' => 1],
            ['name' => 'Voir les courriers', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Voir les taches', 'guard_name' => 'web', 'module_id' => 3],
            ['name' => 'Voir les documents', 'guard_name' => 'web', 'module_id' => 4],
            ['name' => 'Voir les archives', 'guard_name' => 'web', 'module_id' => 5],
            ['name' => 'Gérer le personnel', 'guard_name' => 'web', 'module_id' => 6],
            ['name' => 'Voir les parametres', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => "Voir les lieux d'affectations", 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Directions', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Divisions', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Services', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Sections', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Fonctions', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Grades', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Secretaires', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Voir les Assistants', 'guard_name' => 'web', 'module_id' => 7],
            ['name' => 'Suivi des courriers', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Numériser un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Modifier un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Signer un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Traiter un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Classer un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Cloturer un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Mettre en copie', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Définir la priorité', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Definir le traitement', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => "Définir la date d'échéance", 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Créer un document PDF', 'guard_name' => 'web', 'module_id' => 4],
            ['name' => 'Numériser un document entrant', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Numériser un document sortant', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Numériser un document interne', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Partager un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Assigner une tâche', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Rejeter un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Annoter un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Valider un document', 'guard_name' => 'web', 'module_id' => 2],
            ['name' => 'Archiver', 'guard_name' => 'web', 'module_id' => 4],
            ['name' => 'Telecharger un document', 'guard_name' => 'web', 'module_id' => 4],
            ['name' => 'Imprimer un document', 'guard_name' => 'web', 'module_id' => 4],
            ['name' => 'Désarchiver des documents', 'guard_name' => 'web', 'module_id' => 4],
        ];
        

        DB::table('permissions')->insert($permissions);
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
