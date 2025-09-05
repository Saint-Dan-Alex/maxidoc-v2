<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_destinateur_externes', function (Blueprint $table) {
            $table->id(); // int auto_increment primary key
            $table->string('nom', 191)->nullable()->index('destinataire_nom_idx'); // Using 191 chars for MySQL compatibility
            $table->timestamps(); // created_at et updated_at (nullable)
            $table->softDeletes(); // deleted_at (nullable)
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_destinateur_externes');
    }
};
