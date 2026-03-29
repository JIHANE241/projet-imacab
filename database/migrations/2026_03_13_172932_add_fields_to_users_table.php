<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->after('name')->nullable();
            $table->string('telephone')->after('email')->nullable();
            $table->string('photo')->nullable()->after('telephone');
            $table->enum('role', ['admin', 'responsable', 'candidat'])->default('candidat')->after('photo');
            $table->foreignId('direction_id')->nullable()->constrained()->nullOnDelete()->after('role');
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'telephone', 'photo', 'role', 'direction_id', 'deleted_at']);
        });
    }
};