<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Pour utiliser DB::table()

return new class extends Migration
{
    public function up()
    {
        // Création de la table
        Schema::create('courrier_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedBigInteger('type_id')->nullable();
            $table->timestamps();

            // Définition de la clé étrangère
            $table->foreign('type_id')
                ->references('id')
                ->on('courrier_types')
                ->onDelete('set null');
        });

        // Récupération des IDs des types "Entrant" et "Interne"
        $entrantTypeId = DB::table('courrier_types')->where('titre', 'Entrant')->value('id');
        $interneTypeId = DB::table('courrier_types')->where('titre', 'Interne')->value('id');

        // Définition des catégories
        $categories = [
            ['title' => 'Institution Publique'],
            ['title' => 'Institution Privée'],
            ['title' => 'Entreprise Publique'],
            ['title' => 'Organisme'],
            ['title' => 'Particulier'],
            ['title' => 'Banque'],
            ['title' => 'Cabinet Avocat'],
            ['title' => 'Direction Regionale'],
            ['title' => 'Ministère'],
            ['title' => 'Université'],
            ['title' => 'Autres'],
            ['title' => 'Armée 2'],
            ['title' => 'test'],
            ['title' => 'Eglise'],
            ['title' => 'Essai'],
            ['title' => 'Hopital'],
            ['title' => 'Auberge'],
            ['title' => 'ONG'],
            ['title' => 'Finances'],
            ['title' => 'Administration'],
        ];

        // Ajout des timestamps et du type_id
        $now = now();
        foreach ($categories as &$category) {
            $category['created_at'] = $now;
            $category['updated_at'] = $now;

            if (in_array($category['title'], ['Administration', 'Finances'])) {
                $category['type_id'] = $interneTypeId;
            } else {
                $category['type_id'] = $entrantTypeId;
            }
        }

        // Insertion des catégories
        DB::table('courrier_categories')->insert($categories);
    }

    public function down()
    {
        Schema::dropIfExists('courrier_categories');
    }
};
