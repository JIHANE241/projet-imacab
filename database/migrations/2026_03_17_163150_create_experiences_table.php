<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
public function up()
{
    Schema::create('experiences', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->integer('debut_mois')->nullable();
        $table->integer('debut_annee')->nullable();
        $table->integer('fin_mois')->nullable();
        $table->integer('fin_annee')->nullable();
        $table->boolean('encours')->default(false);
        $table->string('poste');
        $table->string('entreprise')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
