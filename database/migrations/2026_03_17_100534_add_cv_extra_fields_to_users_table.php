<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           
            if (!Schema::hasColumn('users', 'niveau_etude_id')) {
                $table->foreignId('niveau_etude_id')->nullable()->constrained('niveau_etudes')->nullOnDelete();
            }
           
            if (!Schema::hasColumn('users', 'niveau_experience_global')) {
                $table->enum('niveau_experience_global', [
                    'etudiant', 'debutant_moins_2', 'entre_2_5', 'entre_5_10', 'plus_10'
                ])->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['niveau_etude_id', 'niveau_experience_global']);
        });
    }
};