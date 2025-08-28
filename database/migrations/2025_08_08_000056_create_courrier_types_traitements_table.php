<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;


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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Assigner pour traitement',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Valider',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],            
        [
            'titre' => 'Consulter',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Signer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Valider par le D.A ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Valider par le D.F ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Valider par le D.G',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
        [
            'titre' => 'Transmission à la trésorerie',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ],
    ]);

    }

    public function down()
    {
        Schema::dropIfExists('courrier_types_traitements');
    }
}
