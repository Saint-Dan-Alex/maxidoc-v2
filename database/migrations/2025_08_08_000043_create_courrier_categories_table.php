<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->timestamps();
        });

        // Insertion des catégories
        DB::table('courrier_categories')->insert([
            ['title' => 'Institution Publique', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Institution Privée', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Entreprise Publique', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Organisme', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Particulier', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Banque', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cabinet Avocat', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Direction Regionale', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ministère', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Université', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Autres', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Armée 2', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'test', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Eglise', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Essai', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Hopital', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Auberge', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ONG', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_categories');
    }
};
