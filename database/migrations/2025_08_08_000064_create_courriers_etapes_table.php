<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers_etapes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('courrier_id')->nullable()->constrained('courriers')->nullOnDelete();
            $table->foreignId('etape_id')->nullable()->constrained('etapes')->nullOnDelete();
            $table->integer('view_by')->nullable();

            $table->timestamps();
            $table->softDeletes(); // important car deleted_at existe dans la base
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers_etapes');
    }
};
