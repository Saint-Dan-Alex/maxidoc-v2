<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('documents')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('courrier_types')->nullOnDelete();

            $table->unsignedBigInteger('exped_externe')->nullable();
            $table->foreignId('exped_interne_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('dest_externe_id')->nullable()->constrained('courrier_destinateur_externes')->nullOnDelete();
            $table->foreignId('dest_interne_id')->nullable()->constrained('agents')->nullOnDelete();

            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('service_traitant_id')->nullable()->constrained('services')->nullOnDelete();

            $table->boolean('is_intern')->default(true);
            $table->text('title')->nullable();
            $table->boolean('confidentiel')->default(false);
            $table->string('reference_courrier', 200)->nullable();
            $table->string('reference_interne', 200)->nullable();

            $table->foreignId('priorite_id')->nullable()->constrained('priorites')->nullOnDelete();
            $table->timestamp('date_du_courrier')->useCurrent();
            $table->timestamp('date_arrive')->nullable();
            $table->date('date_fin')->nullable();

            $table->foreignId('nature_id')->nullable()->constrained('courrier_natures')->nullOnDelete();
            $table->text('objet')->nullable();

            $table->integer('copie')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('courrier_categories')->nullOnDelete();

            $table->boolean('is_classified')->default(false);
            $table->foreignId('traitement_id')->nullable()->constrained('courrier_traitements')->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('courriers')->nullOnDelete();
            $table->foreignId('statut_id')->nullable()->constrained('statuts')->nullOnDelete();

            $table->timestamps();

            $table->boolean('mark_as_done')->nullable();
            $table->string('etape')->default('en_attente');

            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers');
    }
};
