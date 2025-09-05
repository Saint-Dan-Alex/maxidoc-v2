<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
        });

        // Insertion directe des rôles
        $roles = [ 
            ['name' => 'Super Admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Directeur Générale', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Responsable de Direction', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Assistant', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Secrétaire', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Archiviste', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Service Accueil', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agent', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];
        

        DB::table('roles')->insert($roles);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
