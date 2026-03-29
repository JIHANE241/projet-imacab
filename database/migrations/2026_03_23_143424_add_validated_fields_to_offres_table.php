<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->timestamp('validated_at')->nullable()->after('statut');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['validated_at', 'validated_by']);
        });
    }
};