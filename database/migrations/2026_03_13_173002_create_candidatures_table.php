<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidat_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('offre_id')->constrained()->onDelete('cascade');
            $table->integer('experience')->nullable(); 
            $table->string('adresse')->nullable();
            $table->string('formation')->nullable();
            $table->text('commentaire_rd')->nullable(); 
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee'])->default('en_attente');
            $table->boolean('entretien_planifie')->default(false);
            $table->string('cv_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatures');
    }
};