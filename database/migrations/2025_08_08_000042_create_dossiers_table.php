<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classeur_id')->nullable()->constrained('classeurs')->nullOnDelete();
            $table->string('reference')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->integer('confidentiel')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['classeur_id', 'created_by']);
        });

        // Récupérer l'id du classeur par défaut
        $classeur = DB::table('classeurs')->where('reference', 'DEF-CLASSEUR-001')->first();

        if ($classeur) {
            DB::table('dossiers')->insert([
                'classeur_id' => $classeur->id,
                'reference' => 'DEF-DOSSIER-001',
                'titre' => 'Dossier par défaut',
                'description' => 'Dossier créé automatiquement lié au classeur par défaut',
                'confidentiel' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
};
