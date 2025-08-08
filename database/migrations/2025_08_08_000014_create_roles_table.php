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
            ['name' => 'Admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Responsable Directions', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agents', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
