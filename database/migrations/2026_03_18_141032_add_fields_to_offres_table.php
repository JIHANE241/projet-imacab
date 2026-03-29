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
    Schema::table('offres', function (Blueprint $table) {
        $table->text('missions')->nullable();
        $table->text('profil')->nullable();
        $table->foreignId('niveau_etude_id')->nullable()->constrained('niveau_etudes')->nullOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            //
        });
    }
};
