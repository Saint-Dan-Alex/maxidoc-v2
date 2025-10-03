<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixMigrationOrder extends Migration
{
    public function up()
    {
        // Cette migration ne fait rien d'autre que de forcer un ordre d'exécution
        // Les dépendances seront gérées par Laravel via les contraintes de clé étrangère
    }

    public function down()
    {
        // Ne rien faire en cas de rollback
    }
}
