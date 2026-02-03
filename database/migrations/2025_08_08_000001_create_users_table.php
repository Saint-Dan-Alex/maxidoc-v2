<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->integer('role_id')->nullable();
            $table->integer('statut_id')->nullable();

            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();

            $table->rememberToken();

            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->integer('first_use')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default admin user
        DB::table('users')->insert([
            'name' => 'Admin system',
            'email' => 'calebtshinga@gmail.com',
            'password' => Hash::make('password'),
            'statut_id' => 1,
            'role_id' => 1,
            'email_verified_at' => now(),
            'first_use' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
