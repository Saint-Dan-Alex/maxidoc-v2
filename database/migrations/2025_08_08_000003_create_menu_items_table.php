<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Création de la table 'menu_items'
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->text('policy')->nullable();
            $table->string('target')->default('_self');
            $table->string('icon_regular')->nullable();
            $table->string('icon_solid')->nullable();
            $table->integer('order')->default(0);
            $table->json('parameters')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Optionnel : Ajouter une contrainte de clé étrangère pour 'parent_id'
            // $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
        });

        // Insertion des données dans la table
        DB::table('menu_items')->insert([
            [
                'id' => 25,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Gestion de tâches',
                'url' => '',
                'route' => 'regidoc.taches.index',
                'policy' => 'Voir les taches',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-list-check fi-rr',
                'icon_solid' => 'fi fi-sr-list-check fi-sr',
                'order' => 3,
                'parameters' => null,
                'created_at' => '2022-10-15 10:59:25',
                'updated_at' => '2022-10-15 10:59:25',
                'deleted_at' => null
            ],
            [
                'id' => 28,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Gestion Utilisateurs',
                'url' => '',
                'route' => 'regidoc.personnels.index',
                'policy' => 'Gérer le personnel',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-users-alt fi-rr',
                'icon_solid' => 'fi fi-sr-users-alt fi-sr',
                'order' => 7,
                'parameters' => null,
                'created_at' => '2022-10-15 11:07:43',
                'updated_at' => '2022-10-15 11:07:43',
                'deleted_at' => null
            ],
            [
                'id' => 40,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Paramètres',
                'url' => '',
                'route' => null,
                'policy' => 'Voir les parametres',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-settings fi-rr',
                'icon_solid' => 'fi fi-sr-settings fi-sr',
                'order' => 8,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 48,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'A-propos',
                'url' => '#',
                'route' => null,
                'policy' => 'voir_le_menu_à_propos',
                'target' => '_blank',
                'icon_regular' => 'fi fi-rr-info fi-rr',
                'icon_solid' => 'fi fi-sr-info fi-sr',
                'order' => 10,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => '2023-07-10 07:09:10'
            ],
            [
                'id' => 52,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Archivage',
                'url' => '',
                'route' => 'regidoc.archivages.index',
                'policy' => 'Voir les archives',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-box fi-rr',
                'icon_solid' => 'fi fi-sr-box fi-sr',
                'order' => 5,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 53,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Boîte de reception',
                'url' => '',
                'route' => 'regidoc.courriers.index',
                'policy' => 'Voir les courriers',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-envelope fi-rr',
                'icon_solid' => 'fi fi-sr-envelope fi-sr',
                'order' => 2,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 54,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Section',
                'url' => '',
                'route' => 'regidoc.sections.index',
                'policy' => 'Voir les Sections',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 3,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 55,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Tableau de bord',
                'url' => '/',
                'route' => 'regidoc.home',
                'policy' => 'Voir le tableau de bord',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-apps fi-rr',
                'icon_solid' => 'fi fi-sr-apps fi-sr',
                'order' => 1,
                'parameters' => null,
                'created_at' => '2022-10-14 15:15:06',
                'updated_at' => '2022-10-14 15:15:06',
                'deleted_at' => null
            ],
            [
                'id' => 56,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Chat',
                'url' => '',
                'route' => 'regidoc.chat.index',
                'policy' => 'voir_les_messages',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-comment fi-rr',
                'icon_solid' => 'fi fi-sr-comment fi-sr',
                'order' => 6,
                'parameters' => null,
                'created_at' => '2022-10-15 11:07:43',
                'updated_at' => '2022-10-15 11:07:43',
                'deleted_at' => '2023-07-09 23:00:00'
            ],
            [
                'id' => 57,
                'menu_id' => 1,
                'parent_id' => null,
                'title' => 'Documents',
                'url' => '',
                'route' => 'regidoc.documents.index',
                'policy' => 'Voir les documents',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-folder fi-rr',
                'icon_solid' => 'fi fi-sr-folder fi-sr',
                'order' => 4,
                'parameters' => null,
                'created_at' => '2022-10-14 15:15:06',
                'updated_at' => '2022-10-14 15:15:06',
                'deleted_at' => null
            ],
            [
                'id' => 58,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Directions',
                'url' => '',
                'route' => 'regidoc.directions.index',
                'policy' => 'Voir les Directions',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 2,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 59,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Divisions',
                'url' => '',
                'route' => 'regidoc.divisions.index',
                'policy' => 'Voir les Divisions',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 4,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 60,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Services',
                'url' => '',
                'route' => 'regidoc.services.index',
                'policy' => 'Voir les Services',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 3,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 61,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Fonctions',
                'url' => '',
                'route' => 'regidoc.fonctions.index',
                'policy' => 'Voir les Fonctions',
                'target' => '_self',
                'icon_regular' => 'fi-rr-id-badge',
                'icon_solid' => 'fi-rr-id-badge',
                'order' => 4,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 62,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Grades',
                'url' => '',
                'route' => 'regidoc.grades.index',
                'policy' => 'Voir les Grades',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 7,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 63,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Lieux d\'affectation',
                'url' => '',
                'route' => 'regidoc.lieux.index',
                'policy' => 'Voir les lieux d\'affectations',
                'target' => '_self',
                'icon_regular' => 'fi-rr-map-marker',
                'icon_solid' => 'fi-rr-map-marker',
                'order' => 1,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 64,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Secretariats',
                'url' => '',
                'route' => 'regidoc.secretariats.index',
                'policy' => 'Voir les Secretaires',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 5,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 65,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Gestion Assistanats',
                'url' => '',
                'route' => 'regidoc.assistants.index',
                'policy' => 'Voir les Assistants',
                'target' => '_self',
                'icon_regular' => 'fi-rr-headset',
                'icon_solid' => 'fi-rr-headset',
                'order' => 6,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => null
            ],
            [
                'id' => 66,
                'menu_id' => 1,
                'parent_id' => 40,
                'title' => 'Sessions Log',
                'url' => '',
                'route' => 'regidoc.session',
                'policy' => 'Voir l\'historique des sessions',
                'target' => '_self',
                'icon_regular' => 'fi fi-rr-building fi-rr',
                'icon_solid' => 'fi fi-sr-building fi-sr',
                'order' => 11,
                'parameters' => null,
                'created_at' => '2022-10-15 11:04:19',
                'updated_at' => '2022-10-15 11:04:19',
                'deleted_at' => '2023-09-22 20:42:58'
            ],
            [
                'id' => 67,
                'menu_id' => 67,
                'parent_id' => 40,
                'title' => 'Gestion Catégories',
                'url' => '',
                'route' => 'regidoc.categories.index',
                'policy' => null,
                'target' => '_self',
                'icon_regular' => 'fi-rr-file',
                'icon_solid' => 'fi-rr-file',
                'order' => 8,
                'parameters' => null,
                'created_at' => '2025-08-05 18:49:22',
                'updated_at' => '2025-08-05 18:49:22',
                'deleted_at' => null
            ],
            [
                'id' => 68,
                'menu_id' => 68,
                'parent_id' => 40,
                'title' => 'Gestion Expéditeurs',
                'url' => '',
                'route' => 'regidoc.expediteurs.index',
                'policy' => null,
                'target' => '_self',
                'icon_regular' => 'fi-rr-envelope',
                'icon_solid' => 'fi-rr-envelope',
                'order' => 9,
                'parameters' => null,
                'created_at' => '2025-08-05 18:49:22',
                'updated_at' => '2025-08-05 18:49:22',
                'deleted_at' => null
            ],
            [
                'id' => 69,
                'menu_id' => 69,
                'parent_id' => 40,
                'title' => 'Gestion Natures',
                'url' => '',
                'route' => 'regidoc.natures.index',
                'policy' => null,
                'target' => '_self',
                'icon_regular' => 'fi-rr-document',
                'icon_solid' => 'fi-rr-document',
                'order' => 10,
                'parameters' => null,
                'created_at' => '2025-08-05 18:49:22',
                'updated_at' => '2025-08-05 18:49:22',
                'deleted_at' => null
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};