<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->nullOnDelete();
            $table->string('title');
            $table->string('url');
            $table->string('route')->nullable();
            $table->string('policy')->nullable();
            $table->string('target')->default('_self');
            $table->string('icon_regular', 25)->nullable();
            $table->string('icon_solid', 25)->nullable();
            $table->integer('order');
            $table->text('parameters')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['menu_id', 'parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
