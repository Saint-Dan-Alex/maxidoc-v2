<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->primary(['permission_id', 'model_id', 'model_type']);
            $table->index(['model_id', 'model_type']);
        });

        // Exemple d'insertion: donner toutes les permissions à l'utilisateur id 1
        $permissions = DB::table('permissions')->pluck('id');

        $data = [];
        foreach ($permissions as $permissionId) {
            $data[] = [
                'permission_id' => $permissionId,
                'model_type' => 'App\Models\User', // ou ton namespace User
                'model_id' => 1,
            ];
        }

        DB::table('model_has_permissions')->insert($data);
    }

    public function down()
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
