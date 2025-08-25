<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_expediteurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('nom', 25)->nullable();
            $table->string('contact', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('nom');
        });

        // Insertion des données d'exemple
        DB::table('courrier_expediteurs')->insert([
            ['category_id' => 1, 'nom' => 'Présidence', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'ANAPI', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'Journal officiel', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'Primature', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'SENAT', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'Assemblé Nationnal', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'DGCMP', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'nom' => 'Autre', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'ONATRA', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'SONAS', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'DGRAD', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'DGRK', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'DGDA', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'SCPT', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'CNSS', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'SNEL', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'nom' => 'Autre', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 10, 'nom' => 'UNIKIN', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 10, 'nom' => 'UPN', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'BOA', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'RawBank', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'TMB', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'UBA', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'Afriland', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'Sofibanque', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'BCC', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'Access', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'Equity BCDC', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 9, 'nom' => 'RHE', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 9, 'nom' => 'PORTEF', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 9, 'nom' => 'Autres', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 6, 'nom' => 'Autres', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 10, 'nom' => 'Autres', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 7, 'nom' => 'cabinet peter kazadi', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 5, 'nom' => 'newtch', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 8, 'nom' => 'drb', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'nom' => 'Ministère de finance', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 8, 'nom' => 'Drk', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 8, 'nom' => 'db', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 8, 'nom' => 'Direction regionale Kin', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'nom' => 'LIQUID', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_expediteurs');
    }
};
