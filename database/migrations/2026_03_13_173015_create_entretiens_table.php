<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('heure');
            $table->string('lieu')->nullable();  
            $table->enum('statut', ['planifie', 'passe', 'annule'])->default('planifie');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entretiens');
    }
};