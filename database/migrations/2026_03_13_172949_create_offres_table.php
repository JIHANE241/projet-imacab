<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->foreignId('direction_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_contrat_id')->constrained('type_contrats')->onDelete('cascade');
            $table->foreignId('niveau_experience_id')->constrained('niveau_experiences')->onDelete('cascade');
            $table->foreignId('ville_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('statut', ['brouillon', 'ouverte', 'fermée'])->default('brouillon');
            $table->date('date_publication');
            $table->date('date_limite')->nullable();
            $table->integer('salaire_min')->nullable();
            $table->integer('salaire_max')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offres');
    }
};