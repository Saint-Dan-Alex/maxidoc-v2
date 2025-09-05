<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_traitements', function (Blueprint $table) {
            $table->id(); // id bigint AUTO_INCREMENT
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete(); // agent_id bigint nullable
            $table->longText('note')->nullable(); // note longtext nullable
            $table->text('document_url')->nullable(); // document_url text nullable
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_traitements');
    }
};
