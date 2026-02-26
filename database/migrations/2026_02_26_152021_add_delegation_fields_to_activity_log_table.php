<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historiques', function (Blueprint $table) {
            $table->foreignId('represented_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('delegation_type')->nullable()->default('PO');
        });
    }

    public function down()
    {
        Schema::table('historiques', function (Blueprint $table) {
            $table->dropForeign(['represented_user_id']);
            $table->dropColumn(['represented_user_id', 'delegation_type']);
        });
    }
};
