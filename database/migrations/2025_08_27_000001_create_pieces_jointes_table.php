<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pieces_jointes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('chemin');
            $table->unsignedBigInteger('taille');
            $table->string('mime_type');
            $table->foreignId('courrier_id')->constrained('courriers')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces_jointes');
    }
};
