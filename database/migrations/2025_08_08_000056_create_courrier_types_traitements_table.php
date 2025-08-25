<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourrierTypesTraitementsTable extends Migration
{
    public function up()
    {
        Schema::create('courrier_types_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insérer les données par défaut
        DB::table('courrier_types_traitements')->insert([
            [
                'titre' => 'Traiter',
                'created_at' => '2022-11-14 14:22:39',
                'updated_at' => '2022-11-14 14:22:39',
                'deleted_at' => null,
            ],
            [
                'titre' => 'Assigner pour traitement',
                'created_at' => '2022-11-14 14:22:39',
                'updated_at' => '2022-11-14 14:22:39',
                'deleted_at' => null,
            ],
            [
                'titre' => 'Valider',
                'created_at' => '2022-11-14 14:22:39',
                'updated_at' => '2022-11-14 14:22:39',
                'deleted_at' => null,
            ],            
            [
                'titre' => 'Consulter',
                'created_at' => '2022-11-14 14:34:24',
                'updated_at' => '2022-11-14 14:34:24',
                'deleted_at' => null,
            ],
            [
                'titre' => 'Signer',
                'created_at' => '2023-09-25 10:34:09',
                'updated_at' => '2023-09-25 00:00:00',
                'deleted_at' => null,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_types_traitements');
    }
}
