<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Utiliser une requête SQL brute pour éviter le problème avec Doctrine DBAL
        DB::statement('ALTER TABLE pieces_jointes MODIFY COLUMN chemin TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revenir à VARCHAR(255) si on fait un rollback
        DB::statement('ALTER TABLE pieces_jointes MODIFY COLUMN chemin VARCHAR(255)');
    }
};
