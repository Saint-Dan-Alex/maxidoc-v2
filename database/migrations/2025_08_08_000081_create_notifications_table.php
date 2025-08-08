<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary();   // char(36), clé primaire
            
            $table->string('type');               // varchar(255), NOT NULL
            
            $table->string('notifiable_type')->index(); // varchar(255), NOT NULL + index
            $table->unsignedBigInteger('notifiable_id')->index(); // bigint unsigned, NOT NULL + index
            
            $table->text('data');                 // text, NOT NULL
            
            $table->timestamp('read_at')->nullable(); // timestamp nullable
            
            $table->timestamps();                 // created_at, updated_at (timestamp nullable)
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
