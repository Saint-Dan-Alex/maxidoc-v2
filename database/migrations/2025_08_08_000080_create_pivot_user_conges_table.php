<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pivot_user_conges', function (Blueprint $table) {
            $table->id();
            $table->string('debut', 25);       // varchar(25), NOT NULL
            $table->string('jour', 10)->default('1');  // varchar(10), NOT NULL, default '1'
            $table->string('montant', 25);    // varchar(25), NOT NULL
            
            $table->timestamps();              // created_at & updated_at nullable
            
            $table->string('employe_id')->nullable();  // varchar(255), nullable
            
            $table->unsignedBigInteger('conge_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('statut_id')->default(1)->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pivot_user_conges');
    }
};
